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
use Symfony\Component\HttpFoundation\Response;

class CiudadController extends Controller
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
<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
        $ciudades = $em->getRepository('CiudadBundle:city')->findListaCiudades();
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
        $ciudades = $em->getRepository('CiudadBundle:Ciudad')->findListaCiudades();
=======
        $ciudades = $em->getRepository('AppBundle:Ciudad')->findListaCiudades();
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php

<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
        return $this->render('CiudadBundle:Default:listaCiudades.html.twig', array(
            'ciudadActual' => $city,
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
        return $this->render('CiudadBundle:Default:listaCiudades.html.twig', array(
            'ciudadActual' => $ciudad,
=======
        return $this->render('ciudad/listaCiudades.html.twig', array(
            'ciudadActual' => $ciudad,
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
            'ciudades'     => $ciudades
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
     * Cambia la city activa por la que se indica. En la parte frontal de la
     * application esto simplemente significa que se le redirige al user a la
     * portada de la nueva city seleccionada.
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
     * Cambia la ciudad activa por la que se indica. En la parte frontal de la
     * aplicación esto simplemente significa que se le redirige al usuario a la
     * portada de la nueva ciudad seleccionada.
=======
     * @Route("/ciudad/cambiar-a-{ciudad}", requirements={ "ciudad" = ".+" }, name="ciudad_cambiar")
     *
     * Cambia la ciudad activa por la que se indica. En la parte frontal de la
     * aplicación esto simplemente significa que se le redirige al usuario a la
     * portada de la nueva ciudad seleccionada.
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
     *
<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
     * @param string $city El slug de la city a la que se cambia
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
     * @param string $ciudad El slug de la ciudad a la que se cambia
=======
     * @param string $ciudad El slug de la ciudad a la que se cambia
     * @return RedirectResponse
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
     */
    public function cambiarAction($city)
    {
        return new RedirectResponse($this->generateUrl('portada', array('city' => $city)));
    }

    /**
<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
     * Muestra las ofertas más recientes de la city indicada
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
     * Muestra las ofertas más recientes de la ciudad indicada
=======
     * @Route("/{ciudad}/recientes", name="ciudad_recientes")
     * @Cache(smaxage="3600")
     *
     * Muestra las ofertas más recientes de la ciudad indicada
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
     *
<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
     * @param string $city El slug de la city
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
     * @param string $ciudad El slug de la ciudad
=======
     * @param string $ciudad El slug de la ciudad
     * @return Response
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
     */
    public function recientesAction($city)
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
        $city = $em->getRepository('CiudadBundle:city')->findOneBySlug($city);
        if (!$city) {
            throw $this->createNotFoundException('La city indicada no está disponible');
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
        $ciudad = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        if (!$ciudad) {
            throw $this->createNotFoundException('La ciudad indicada no está disponible');
=======
        $ciudad = $em->getRepository('AppBundle:Ciudad')->findOneBySlug($ciudad);
        if (!$ciudad) {
            throw $this->createNotFoundException('La ciudad indicada no está disponible');
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
        }

<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
        $cercanas = $em->getRepository('CiudadBundle:city')->findCercanas($city->getId());
        $ofertas  = $em->getRepository('OfertaBundle:offer')->findRecientes($city->getId());
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
        $cercanas = $em->getRepository('CiudadBundle:Ciudad')->findCercanas($ciudad->getId());
        $ofertas  = $em->getRepository('OfertaBundle:Oferta')->findRecientes($ciudad->getId());
=======
        $cercanas = $em->getRepository('AppBundle:Ciudad')->findCercanas($ciudad->getId());
        $ofertas  = $em->getRepository('AppBundle:Oferta')->findRecientes($ciudad->getId());
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php

        $formato = $this->get('request')->getRequestFormat();
<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php
        $response = $this->render('CiudadBundle:Default:recientes.'.$formato.'.twig', array(
            'city'   => $city,
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php
        $respuesta = $this->render('CiudadBundle:Default:recientes.'.$formato.'.twig', array(
            'ciudad'   => $ciudad,
=======
        return $this->render('ciudad/recientes.'.$formato.'.twig', array(
            'ciudad'   => $ciudad,
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
            'cercanas' => $cercanas,
            'ofertas'  => $ofertas
        ));
<<<<<<< HEAD:src/Cupon/CiudadBundle/Controller/DefaultController.php

        $response->setSharedMaxAge(3600);

        return $response;
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Controller/DefaultController.php

        $respuesta->setSharedMaxAge(3600);

        return $respuesta;
=======
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/CiudadController.php
    }
}
