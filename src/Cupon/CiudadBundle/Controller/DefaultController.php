<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\CiudadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * Busca todas las ciudades disponibles en la base de datos y pasa la lista
     * a una template muy sencilla que simplemente muestra una lista desplegable
     * para seleccionar la city activa.
     *
     * @param string $city El slug de la city seleccionada
     */
    public function listaCiudadesAction($city = null)
    {
        $em = $this->getDoctrine()->getManager();
        $ciudades = $em->getRepository('CiudadBundle:city')->findListaCiudades();

        return $this->render('CiudadBundle:Default:listaCiudades.html.twig', array(
            'ciudadActual' => $city,
            'ciudades'     => $ciudades
        ));
    }

    /**
     * Cambia la city activa por la que se indica. En la parte frontal de la
     * application esto simplemente significa que se le redirige al user a la
     * portada de la nueva city seleccionada.
     *
     * @param string $city El slug de la city a la que se cambia
     */
    public function cambiarAction($city)
    {
        return new RedirectResponse($this->generateUrl('portada', array('city' => $city)));
    }

    /**
     * Muestra las ofertas más recientes de la city indicada
     *
     * @param string $city El slug de la city
     */
    public function recientesAction($city)
    {
        $em = $this->getDoctrine()->getManager();

        $city = $em->getRepository('CiudadBundle:city')->findOneBySlug($city);
        if (!$city) {
            throw $this->createNotFoundException('La city indicada no está disponible');
        }

        $cercanas = $em->getRepository('CiudadBundle:city')->findCercanas($city->getId());
        $ofertas  = $em->getRepository('OfertaBundle:offer')->findRecientes($city->getId());

        $formato = $this->get('request')->getRequestFormat();
        $response = $this->render('CiudadBundle:Default:recientes.'.$formato.'.twig', array(
            'city'   => $city,
            'cercanas' => $cercanas,
            'ofertas'  => $ofertas
        ));

        $response->setSharedMaxAge(3600);

        return $response;
    }
}
