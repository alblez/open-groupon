<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\city;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CiudadController extends Controller
{
    /**
     * Busca todas las ciudades disponibles en la base de datos y pasa la lista
     * a una template muy sencilla que simplemente muestra una lista desplegable
     * para seleccionar la city activa.
     *
     * @param string $city El slug de la city seleccionada
     *
     * @return Response
     */
    public function listaCiudadesAction($city = null)
    {
        $em = $this->getDoctrine()->getManager();
        $ciudades = $em->getRepository('AppBundle:city')->findListaCiudades();

        return $this->render('city/listaCiudades.html.twig', array(
            'ciudadActual' => $city,
            'ciudades' => $ciudades,
        ));
    }

    /**
     * Cambia la city activa por la que se indica. En la parte frontal de la
     * application esto simplemente significa que se le redirige al user a la
     * portada de la nueva city seleccionada.
     *
     * @Route("/city/cambiar-a-{city}", requirements={ "city" = ".+" }, name="ciudad_cambiar")
     *
     * @param string $city El slug de la city a la que se cambia
     *
     * @return RedirectResponse
     */
    public function cambiarAction($city)
    {
        return $this->redirectToRoute('portada', array('city' => $city));
    }

    /**
     * Muestra las ofertas más recientes de la city indicada.
     *
     * @Route("/{slug}/recientes", name="ciudad_recientes")
     * @Cache(smaxage="3600")
     *
     * @param city $city El slug de la city
     *
     * @return Response
     */
    public function recientesAction(Request $request, city $city)
    {
        $em = $this->getDoctrine()->getManager();
        $cercanas = $em->getRepository('AppBundle:city')->findCercanas($city->getId());
        $ofertas = $em->getRepository('AppBundle:offer')->findRecientes($city->getId());

        $formato = $request->getRequestFormat();

        return $this->render('city/recientes.'.$formato.'.twig', array(
            'city' => $city,
            'cercanas' => $cercanas,
            'ofertas' => $ofertas,
        ));
    }
}
