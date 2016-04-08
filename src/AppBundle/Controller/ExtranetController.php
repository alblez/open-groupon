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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * la application.
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
     * Muestra las ventas registradas para la offer indicada.
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
        $store = $this->get('security.token_storage')->getToken()->getUser();

        $offer = offer::crearParaTienda($store);
        $form = $this->createForm('AppBundle\Form\Extranet\OfertaType', $offer, array('mostrar_condiciones' => true));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('app.manager.oferta_manager')->guardar($offer);

            return $this->redirectToRoute('extranet_portada');
        }

        return $this->render(
            'extranet/offer.html.twig', array(
            'accion' => 'crear',
            'form' => $form->createView(),
        ));
    }

    /**
     * Muestra el form para editar una offer y se encarga del
     * procesamiento de la información recibida y la modificación de los
     * datos de las entidades de type offer.
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
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('app.manager.oferta_manager')->guardar($offer);

            return $this->redirectToRoute('extranet_portada');
        }

        return $this->render(
            'extranet/offer.html.twig', array(
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
