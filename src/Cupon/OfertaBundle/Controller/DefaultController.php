<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * Muestra la portada del sitio web
     *
     * @param string $city El slug de la city activa en la application
     */
    public function portadaAction($city)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $offer = $em->getRepository('OfertaBundle:offer')->findOfertaDelDia($city);

        if (!$offer) {
            throw $this->createNotFoundException('No se ha encontrado ninguna offer del día en la city seleccionada');
        }

        $response = $this->render('OfertaBundle:Default:portada.html.twig', array(
            'offer' => $offer
        ));
        $response->setSharedMaxAge(60);

        return $response;
    }

    /**
     * Muestra la page de detalle de la offer indicada
     *
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer (el mismo slug se puede dar en dos o más ciudades diferentes)
     */
    public function ofertaAction($city, $slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $offer   = $em->getRepository('OfertaBundle:offer')->findOferta($city, $slug);
        $cercanas = $em->getRepository('OfertaBundle:offer')->findCercanas($city);

        if (!$offer) {
            throw $this->createNotFoundException('No se ha encontrado la offer solicitada');
        }

        $response = $this->render('OfertaBundle:Default:detalle.html.twig', array(
            'cercanas' => $cercanas,
            'offer'   => $offer
        ));

        $response->setSharedMaxAge(60);

        return $response;
    }
}
