<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\offer;
use AppBundle\Form\Extranet\OfertaType;
use AppBundle\Form\Extranet\TiendaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints\IsTrue;

class ExtranetController extends Controller
{
    /**
     * @Route("/login", name="extranet_login")
     * Muestra el form de login
     */
    public function loginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('extranet/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/login_check", name="extranet_login_check")
     */
    public function loginCheckAction()
    {
        // el "login check" lo hace Symfony automáticamente, pero es necesario
        // definir una ruta /login_check. Por eso existe este method vacío.
    }

    /**
     * @Route("/logout", name="extranet_logout")
     */
    public function logoutAction()
    {
        // el logout lo hace Symfony automáticamente, pero es necesario
        // definir una ruta /logout. Por eso existe este method vacío.
    }

    /**
     * Muestra la portada de la extranet de la store que está logueada en
     * la application
     *
     * @Route("/", name="extranet_portada")
     */
    public function portadaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $store = $this->get('security.token_storage')->getToken()->getUser();
        $ofertas = $em->getRepository('AppBundle:store')->findOfertasRecientes($store->getId(), 50);

        return $this->render('extranet/portada.html.twig', array(
            'ofertas' => $ofertas,
        ));
    }

    /**
     * Muestra las ventas registradas para la offer indicada
     *
     * @Route("/offer/ventas/{id}", name="extranet_oferta_ventas")
     */
    public function ofertaVentasAction(offer $offer)
    {
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:offer')->findVentasByOferta($offer->getId());

        return $this->render('extranet/ventas.html.twig', array(
            'offer' => $offer,
            'ventas' => $ventas,
        ));
    }

    /**
     * Muestra el form para crear una nueva offer y se encarga del
     * procesamiento de la información recibida y la creación de las nuevas
     * entidades de type offer.
     *
     * @Route("/offer/nueva", name="extranet_oferta_nueva")
     */
    public function ofertaNuevaAction(Request $request)
    {
        $offer = new offer();
        $form = $this->createForm('AppBundle\Form\Extranet\OfertaType', $offer);

        // Cuando se creates una offer, se muestra un checkbox para aceptar las
        // condiciones de uso. Este campo de form no se corresponde con
        // ninguna propiedad de la entity, por lo que se añade dinámicamente
        // al form
        $form->add('acepto', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array(
            'mapped' => false,
            'constraints' => new IsTrue(array(
                'message' => 'Debes aceptar las condiciones indicadas antes de poder añadir una nueva offer'
            )),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Completar las propiedades de la offer que una store no puede establecer
            $store = $this->get('security.token_storage')->getToken()->getUser();
            $offer->setTienda($store);
            $offer->setCiudad($store->getCiudad());

            // Copiar la photo subida y guardar la ruta
            $offer->subirFoto($this->container->getParameter('cupon.directorio.imagenes'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('extranet_portada');
        }

        return $this->render('extranet/form.html.twig', array(
            'accion' => 'crear',
            'form' => $form->createView(),
        ));
    }

    /**
     * Muestra el form para editar una offer y se encarga del
     * procesamiento de la información recibida y la modificación de los
     * datos de las entidades de type offer
     *
     * @Route("/offer/editar/{id}", requirements={ "city" = ".+" }, name="extranet_oferta_editar")
     */
    public function ofertaEditarAction(Request $request, offer $offer)
    {
        $this->denyAccessUnlessGranted('ROLE_EDITAR_OFERTA', $offer);

        // Una offer sólo se puede modificar si todavía no ha sido revisada por los administradores
        if ($offer->getRevisada()) {
            $this->addFlash('error', 'La offer indicada no se puede modificar porque ya ha sido revisada por los administradores');

            return $this->redirectToRoute('extranet_portada');
        }

        $form = $this->createForm('AppBundle\Form\Extranet\OfertaType', $offer);

        // Guardar la ruta de la photo original de la offer
        $rutaFotoOriginal = $form->getData()->getRutaFoto();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Si el user no ha modificado la photo, su value actual es null
            if (null == $offer->getFoto()) {
                // Guardar la ruta original de la photo en la offer y no hacer nada más
                $offer->setRutaFoto($rutaFotoOriginal);
            }
            // El user ha cambiado la photo
            else {
                // Copiar la photo subida y guardar la nueva ruta
                $offer->subirFoto($this->container->getParameter('cupon.directorio.imagenes'));

                // Borrar la photo anterior
                if (!empty($rutaFotoOriginal)) {
                    $fs = new Filesystem();
                    $fs->remove($this->container->getParameter('cupon.directorio.imagenes').$rutaFotoOriginal);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('extranet_portada');
        }

        return $this->render('extranet/form.html.twig', array(
            'accion' => 'editar',
            'offer' => $offer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Muestra el form para editar los datos del perfil de la store que está
     * logueada en la application. También se encarga de procesar la información y
     * guardar las modificaciones en la base de datos.
     *
     * @Route("/perfil", name="extranet_perfil")
     */
    public function perfilAction(Request $request)
    {
        $store = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('AppBundle\Form\Extranet\TiendaType', $store);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('app.manager.tienda_manager')->guardar($store);
            $this->addFlash('info', 'Los datos de tu perfil se han actualizado correctamente');

            return $this->redirectToRoute('extranet_portada');
        }

        return $this->render('extranet/perfil.html.twig', array(
            'store' => $store,
            'form' => $form->createView(),
        ));
    }
}
