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
use Symfony\Component\HttpFoundation\RedirectResponse;

class OfertaController extends Controller
{
    /**
     * @Route("/{ciudad}", defaults={ "ciudad" = "%cupon.ciudad_por_defecto%" }, name="portada")
     * Muestra la portada del sitio web
     *
     * @param string $city El slug de la city activa en la application
     */
    public function portadaAction($city)
    {
        $em = $this->getDoctrine()->getManager();
<<<<<<< HEAD:src/Cupon/OfertaBundle/Controller/DefaultController.php
        $offer = $em->getRepository('OfertaBundle:offer')->findOfertaDelDia($city);
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Controller/DefaultController.php
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOfertaDelDia($ciudad);
=======
        $oferta = $em->getRepository('AppBundle:Oferta')->findOfertaDelDia($ciudad);
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/OfertaController.php

        if (!$offer) {
            throw $this->createNotFoundException('No se ha encontrado ninguna offer del día en la city seleccionada');
        }

<<<<<<< HEAD:src/Cupon/OfertaBundle/Controller/DefaultController.php
        $response = $this->render('OfertaBundle:Default:portada.html.twig', array(
            'offer' => $offer
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Controller/DefaultController.php
        $respuesta = $this->render('OfertaBundle:Default:portada.html.twig', array(
            'oferta' => $oferta
=======
        $respuesta = $this->render('oferta/portada.html.twig', array(
            'oferta' => $oferta
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/OfertaController.php
        ));
        $response->setSharedMaxAge(60);

        return $response;
    }

    /**
<<<<<<< HEAD:src/Cupon/OfertaBundle/Controller/DefaultController.php
     * Muestra la page de detalle de la offer indicada
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Controller/DefaultController.php
     * Muestra la página de detalle de la oferta indicada
=======
     * @Route("/{ciudad}/ofertas/{slug}", name="oferta")
     * Muestra la página de detalle de la oferta indicada
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/OfertaController.php
     *
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer (el mismo slug se puede dar en dos o más ciudades diferentes)
     */
    public function ofertaAction($city, $slug)
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<< HEAD:src/Cupon/OfertaBundle/Controller/DefaultController.php
        $offer   = $em->getRepository('OfertaBundle:offer')->findOferta($city, $slug);
        $cercanas = $em->getRepository('OfertaBundle:offer')->findCercanas($city);
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Controller/DefaultController.php
        $oferta   = $em->getRepository('OfertaBundle:Oferta')->findOferta($ciudad, $slug);
        $cercanas = $em->getRepository('OfertaBundle:Oferta')->findCercanas($ciudad);
=======
        $oferta   = $em->getRepository('AppBundle:Oferta')->findOferta($ciudad, $slug);
        $cercanas = $em->getRepository('AppBundle:Oferta')->findCercanas($ciudad);
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/OfertaController.php

        if (!$offer) {
            throw $this->createNotFoundException('No se ha encontrado la offer solicitada');
        }

<<<<<<< HEAD:src/Cupon/OfertaBundle/Controller/DefaultController.php
        $response = $this->render('OfertaBundle:Default:detalle.html.twig', array(
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Controller/DefaultController.php
        $respuesta = $this->render('OfertaBundle:Default:detalle.html.twig', array(
=======
        $respuesta = $this->render('oferta/detalle.html.twig', array(
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/OfertaController.php
            'cercanas' => $cercanas,
            'offer'   => $offer
        ));

        $response->setSharedMaxAge(60);

        return $response;
    }
}
