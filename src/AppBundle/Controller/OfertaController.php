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

class OfertaController extends Controller
{
    /**
     * Muestra la page de detalle de la offer indicada.
     *
     * @Route("/{city}/ofertas/{slug}", name="offer")
     * @Cache(smaxage="60")
     *
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer (es único en cada city)
     */
    public function ofertaAction($city, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('AppBundle:offer')->findOferta($city, $slug);
        $cercanas = $em->getRepository('AppBundle:offer')->findCercanas($city);

        if (!$offer) {
            throw $this->createNotFoundException('No se ha encontrado la offer solicitada');
        }

        return $this->render('offer/detalle.html.twig', array(
            'cercanas' => $cercanas,
            'offer' => $offer,
        ));
    }
}
