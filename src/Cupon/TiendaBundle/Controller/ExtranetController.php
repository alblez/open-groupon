<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\TiendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Cupon\OfertaBundle\Entity\offer;
use Cupon\OfertaBundle\Form\Extranet\OfertaType;
use Cupon\TiendaBundle\Form\Extranet\TiendaType;

class ExtranetController extends Controller
{
    /**
     * Muestra el form de login
     */
    public function loginAction(Request $peticion)
    {
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('TiendaBundle:Extranet:login.html.twig', array(
            'error' => $error
        ));
    }

    /**
     * Muestra la portada de la extranet de la store que está logueada en
     * la application
     */
    public function portadaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $store = $this->get('security.context')->getToken()->getUser();
        $ofertas = $em->getRepository('TiendaBundle:store')->findOfertasRecientes($store->getId(), 50);

        return $this->render('TiendaBundle:Extranet:portada.html.twig', array(
            'ofertas' => $ofertas
        ));
    }

    /**
     * Muestra las ventas registradas para la offer indicada
     *
     * @param string $id El id de la offer para la que se buscan sus ventas
     */
    public function ofertaVentasAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ventas = $em->getRepository('OfertaBundle:offer')->findVentasByOferta($id);

        return $this->render('TiendaBundle:Extranet:ventas.html.twig', array(
            'offer' => $ventas[0]->getOferta(),
            'ventas' => $ventas
        ));
    }

    /**
     * Muestra el form para crear una nueva offer y se encarga del
     * procesamiento de la información recibida y la creación de las nuevas
     * entidades de type offer
     */
    public function ofertaNuevaAction(Request $peticion)
    {
        $offer = new offer();
        $form = $this->createForm(new OfertaType(), $offer);

        $form->handleRequest($peticion);

        if ($form->isValid()) {
            // Completar las propiedades de la offer que una store no puede establecer
            $store = $this->get('security.context')->getToken()->getUser();
            $offer->setCompras(0);
            $offer->setRevisada(false);
            $offer->setTienda($store);
            $offer->setCiudad($store->getCiudad());

            // Copiar la photo subida y guardar la ruta
            $offer->subirFoto($this->container->getParameter('cupon.directorio.imagenes'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            return $this->redirect($this->generateUrl('extranet_portada'));
        }

        return $this->render('TiendaBundle:Extranet:form.html.twig', array(
            'accion'     => 'crear',
            'form' => $form->createView()
        ));
    }

    /**
     * Muestra el form para editar una offer y se encarga del
     * procesamiento de la información recibida y la modificación de los
     * datos de las entidades de type offer
     *
     * @param string $id El id de la offer a modificar
     */
    public function ofertaEditarAction(Request $peticion, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('OfertaBundle:offer')->find($id);

        if (!$offer) {
            throw $this->createNotFoundException('La offer indicada no está disponible');
        }

        // Comprobar que el user tiene permiso para editar esta offer concreta
        if (false === $this->get('security.context')->isGranted('ROLE_EDITAR_OFERTA', $offer)) {
            throw new AccessDeniedException();
        }

        // Una offer sólo se puede modificar si todavía no ha sido revisada por los administradores
        if ($offer->getRevisada()) {
            $this->get('session')->getFlashBag()->add('error',
                'La offer indicada no se puede modificar porque ya ha sido revisada por los administradores'
            );

            return $this->redirect($this->generateUrl('extranet_portada'));
        }

        $form = $this->createForm(new OfertaType(), $offer);

        // Guardar la ruta de la photo original de la offer
        $rutaFotoOriginal = $form->getData()->getRutaFoto();

        $form->handleRequest($peticion);

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

            $em->persist($offer);
            $em->flush();

            return $this->redirect($this->generateUrl('extranet_portada'));
        }

        return $this->render('TiendaBundle:Extranet:form.html.twig', array(
            'accion'     => 'editar',
            'offer'     => $offer,
            'form' => $form->createView()
        ));
    }

    /**
     * Muestra el form para editar los datos del perfil de la store que está
     * logueada en la application. También se encarga de procesar la información y
     * guardar las modificaciones en la base de datos
     */
    public function perfilAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $store = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new TiendaType(), $store);

        $passwordOriginal = $form->getData()->getPassword();

        $form->handleRequest($peticion);

        if ($form->isValid()) {
            // Si el user no ha cambiado el password, su value es null después de
            // hacer el ->bindRequest(), por lo que hay que recuperar el value original
            if (null == $store->getPassword()) {
                $store->setPassword($passwordOriginal);
            }
            // Si el user ha cambiado su password, hay que codificarlo antes de guardarlo
            else {
                $encoder = $this->get('security.encoder_factory')->getEncoder($store);
                $passwordCodificado = $encoder->encodePassword(
                    $store->getPassword(),
                    $store->getSalt()
                );
                $store->setPassword($passwordCodificado);
            }

            $em->persist($store);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info',
                'Los datos de tu perfil se han actualizado correctamente'
            );

            return $this->redirect($this->generateUrl('extranet_portada'));
        }

        return $this->render('TiendaBundle:Extranet:perfil.html.twig', array(
            'store'     => $store,
            'form' => $form->createView()
        ));
    }
}
