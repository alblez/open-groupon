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
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TiendaController extends Controller
{
    /**
     * @Route("/{city}/tiendas/{store}", requirements={ "city" = ".+" }, name="tienda_portada")
     * @Cache(smaxage="3600")
     *
     * Muestra la portada de cada store, que muestra su información y las
     * ofertas que ha publicado recientemente.
     *
     * @param Request $request
     * @param string  $city  El slug de la city donde se encuentra la store
     * @param string  $store  El slug de la store
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function portadaAction(Request $request, $city, $store)
    {
        $em = $this->getDoctrine()->getManager();

        $city = $em->getRepository('AppBundle:city')->findOneBySlug($city);
        $store = $em->getRepository('AppBundle:store')->findOneBy(array(
            'slug' => $store,
            'city' => $city->getId(),
        ));

        if (!$store) {
            throw $this->createNotFoundException('La store indicada no está disponible');
        }

        $ofertas = $em->getRepository('AppBundle:store')->findUltimasOfertasPublicadas($store->getId());
        $cercanas = $em->getRepository('AppBundle:store')->findCercanas(
            $store->getSlug(),
            $store->getCiudad()->getSlug()
        );

        $formato = $request->getRequestFormat();

        return $this->render('store/portada.'.$formato.'.twig', array(
            'store' => $store,
            'ofertas' => $ofertas,
            'cercanas' => $cercanas,
        ));
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
=======

class TiendaController extends Controller
{
    /**
<<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/DefaultController.php
     * Muestra la portada de cada store, que muestra su información y las
|||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/DefaultController.php
     * Muestra la portada de cada tienda, que muestra su información y las
========
     * @Route("/{ciudad}/tiendas/{tienda}", requirements={ "ciudad" = ".+" }, name="tienda_portada")
     *
     * Muestra la portada de cada tienda, que muestra su información y las
>>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/TiendaController.php
     * ofertas que ha publicado recientemente
     *
     * @param string $city El slug de la city donde se encuentra la store
     * @param string $store El slug de la store
     */
    public function portadaAction($city, $store)
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/DefaultController.php
        $city = $em->getRepository('CiudadBundle:city')->findOneBySlug($city);
        $store = $em->getRepository('TiendaBundle:store')->findOneBy(array(
            'slug' => $store,
            'city' => $city->getId()
|||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/DefaultController.php
        $ciudad = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        $tienda = $em->getRepository('TiendaBundle:Tienda')->findOneBy(array(
            'slug' => $tienda,
            'ciudad' => $ciudad->getId()
========
        $ciudad = $em->getRepository('AppBundle:Ciudad')->findOneBySlug($ciudad);
        $tienda = $em->getRepository('AppBundle:Tienda')->findOneBy(array(
            'slug' => $tienda,
            'ciudad' => $ciudad->getId()
>>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/TiendaController.php
        ));

        if (!$store) {
            throw $this->createNotFoundException('La store indicada no está disponible');
        }

<<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/DefaultController.php
        $ofertas = $em->getRepository('TiendaBundle:store')->findUltimasOfertasPublicadas($store->getId());
        $cercanas = $em->getRepository('TiendaBundle:store')->findCercanas(
            $store->getSlug(),
            $store->getCiudad()->getSlug()
|||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/DefaultController.php
        $ofertas = $em->getRepository('TiendaBundle:Tienda')->findUltimasOfertasPublicadas($tienda->getId());
        $cercanas = $em->getRepository('TiendaBundle:Tienda')->findCercanas(
            $tienda->getSlug(),
            $tienda->getCiudad()->getSlug()
========
        $ofertas = $em->getRepository('AppBundle:Tienda')->findUltimasOfertasPublicadas($tienda->getId());
        $cercanas = $em->getRepository('AppBundle:Tienda')->findCercanas(
            $tienda->getSlug(),
            $tienda->getCiudad()->getSlug()
>>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/TiendaController.php
        );

        $formato = $this->get('request')->getRequestFormat();
<<<<<<<< HEAD:src/Cupon/TiendaBundle/Controller/DefaultController.php
        $response = $this->render('TiendaBundle:Default:portada.'.$formato.'.twig', array(
            'store'   => $store,
|||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Controller/DefaultController.php
        $respuesta = $this->render('TiendaBundle:Default:portada.'.$formato.'.twig', array(
            'tienda'   => $tienda,
========
        $respuesta = $this->render('tienda/portada.'.$formato.'.twig', array(
            'tienda'   => $tienda,
>>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/TiendaController.php
            'ofertas'  => $ofertas,
            'cercanas' => $cercanas
        ));

        $response->setSharedMaxAge(3600);

        return $response;
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
    }
}
