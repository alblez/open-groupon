<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
use Cupon\OfertaBundle\Entity\offer;
use Cupon\OfertaBundle\Form\Extranet\OfertaType;
use Cupon\TiendaBundle\Form\Extranet\TiendaType;
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
use Cupon\OfertaBundle\Entity\Oferta;
use Cupon\OfertaBundle\Form\Extranet\OfertaType;
use Cupon\TiendaBundle\Form\Extranet\TiendaType;
=======
use AppBundle\Entity\Oferta;
use AppBundle\Form\Extranet\OfertaType;
use AppBundle\Form\Extranet\TiendaType;
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php

/**
 * @Route("/extanet")
 */
class ExtranetController extends Controller
{
    /**
<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el form de login
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el formulario de login
=======
     * @Route("/login", name="extranet_login")
     * Muestra el formulario de login
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
     */
    public function loginAction(Request $peticion)
    {
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('extranet/login.html.twig', array(
            'error' => $error
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra la portada de la extranet de la store que está logueada en
     * la application
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra la portada de la extranet de la tienda que está logueada en
     * la aplicación
=======
     * @Route("/login_check", name="extranet_login_check")
     */
    public function loginCheckAction()
    {
        // el "login check" lo hace Symfony automáticamente
    }

    /**
     * @Route("/logout", name="extranet_logout")
     */
    public function logoutAction()
    {
        // el logout lo hace Symfony automáticamente
    }

    /**
     * @Route("/", name="extranet_portada")
     * Muestra la portada de la extranet de la tienda que está logueada en
     * la aplicación
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
     */
    public function portadaAction()
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
        $store = $this->get('security.context')->getToken()->getUser();
        $ofertas = $em->getRepository('TiendaBundle:store')->findOfertasRecientes($store->getId(), 50);
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
        $tienda = $this->get('security.context')->getToken()->getUser();
        $ofertas = $em->getRepository('TiendaBundle:Tienda')->findOfertasRecientes($tienda->getId(), 50);
=======
        $tienda = $this->get('security.context')->getToken()->getUser();
        $ofertas = $em->getRepository('AppBundle:Tienda')->findOfertasRecientes($tienda->getId(), 50);
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php

        return $this->render('extranet/portada.html.twig', array(
            'ofertas' => $ofertas
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra las ventas registradas para la offer indicada
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra las ventas registradas para la oferta indicada
=======
     * @Route("/oferta/ventas/{id}", name="extranet_oferta_ventas")
     * Muestra las ventas registradas para la oferta indicada
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
     *
     * @param string $id El id de la offer para la que se buscan sus ventas
     */
    public function ofertaVentasAction($id)
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
        $ventas = $em->getRepository('OfertaBundle:offer')->findVentasByOferta($id);
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
        $ventas = $em->getRepository('OfertaBundle:Oferta')->findVentasByOferta($id);
=======
        $ventas = $em->getRepository('AppBundle:Oferta')->findVentasByOferta($id);
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php

<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:ventas.html.twig', array(
            'offer' => $ventas[0]->getOferta(),
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:ventas.html.twig', array(
            'oferta' => $ventas[0]->getOferta(),
=======
        return $this->render('extranet/ventas.html.twig', array(
            'oferta' => $ventas[0]->getOferta(),
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
            'ventas' => $ventas
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el form para crear una nueva offer y se encarga del
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el formulario para crear una nueva oferta y se encarga del
=======
     * @Route("/oferta/nueva", name="extranet_oferta_nueva")
     * Muestra el formulario para crear una nueva oferta y se encarga del
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
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

<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:form.html.twig', array(
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:formulario.html.twig', array(
=======
        return $this->render('extranet/formulario.html.twig', array(
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
            'accion'     => 'crear',
            'form' => $form->createView()
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el form para editar una offer y se encarga del
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el formulario para editar una oferta y se encarga del
=======
     * @Route("/oferta/editar/{id}", requirements={ "ciudad" = ".+" }, name="extranet_oferta_editar")
     * Muestra el formulario para editar una oferta y se encarga del
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
     * procesamiento de la información recibida y la modificación de los
     * datos de las entidades de type offer
     *
     * @param string $id El id de la offer a modificar
     */
    public function ofertaEditarAction(Request $peticion, $id)
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
        $offer = $em->getRepository('OfertaBundle:offer')->find($id);
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
        $oferta = $em->getRepository('OfertaBundle:Oferta')->find($id);
=======
        $oferta = $em->getRepository('AppBundle:Oferta')->find($id);
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php

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

<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:form.html.twig', array(
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:formulario.html.twig', array(
=======
        return $this->render('extranet/formulario.html.twig', array(
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
            'accion'     => 'editar',
            'offer'     => $offer,
            'form' => $form->createView()
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el form para editar los datos del perfil de la store que está
     * logueada en la application. También se encarga de procesar la información y
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
     * Muestra el formulario para editar los datos del perfil de la tienda que está
     * logueada en la aplicación. También se encarga de procesar la información y
=======
     * @Route("/perfil", name="extranet_perfil")
     * Muestra el formulario para editar los datos del perfil de la tienda que está
     * logueada en la aplicación. También se encarga de procesar la información y
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
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

<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:perfil.html.twig', array(
            'store'     => $store,
            'form' => $form->createView()
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/ExtranetController.php
        return $this->render('TiendaBundle:Extranet:perfil.html.twig', array(
            'tienda'     => $tienda,
            'formulario' => $formulario->createView()
=======
        return $this->render('extranet/perfil.html.twig', array(
            'tienda'     => $tienda,
            'formulario' => $formulario->createView()
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/ExtranetController.php
        ));
    }
}
