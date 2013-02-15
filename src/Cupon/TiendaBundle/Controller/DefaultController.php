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

class DefaultController extends Controller
{
    /**
     * Muestra la portada de cada store, que muestra su información y las
     * ofertas que ha publicado recientemente
     *
     * @param string $city El slug de la city donde se encuentra la store
     * @param string $store El slug de la store
     */
    public function portadaAction($city, $store)
    {
        $em = $this->getDoctrine()->getManager();

        $city = $em->getRepository('CiudadBundle:city')->findOneBySlug($city);
        $store = $em->getRepository('TiendaBundle:store')->findOneBy(array(
            'slug' => $store,
            'city' => $city->getId()
        ));

        if (!$store) {
            throw $this->createNotFoundException('La store indicada no está disponible');
        }

        $ofertas = $em->getRepository('TiendaBundle:store')->findUltimasOfertasPublicadas($store->getId());
        $cercanas = $em->getRepository('TiendaBundle:store')->findCercanas(
            $store->getSlug(),
            $store->getCiudad()->getSlug()
        );

        $formato = $this->get('request')->getRequestFormat();
        $response = $this->render('TiendaBundle:Default:portada.'.$formato.'.twig', array(
            'store'   => $store,
            'ofertas'  => $ofertas,
            'cercanas' => $cercanas
        ));

        $response->setSharedMaxAge(3600);

        return $response;
    }
}
