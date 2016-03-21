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
use Symfony\Component\HttpFoundation\Response;

class TiendaController extends Controller
{
    /**
<<<<<<< HEAD
     * @Route("/{city}/tiendas/{store}", requirements={ "city" = ".+" }, name="tienda_portada")
     * @Cache(smaxage="3600")
     *
     * Muestra la portada de cada store, que muestra su información y las
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
     * @Route("/{city}/tiendas/{store}", requirements={ "city" = ".+" }, name="tienda_portada")
     * @Cache(smaxage="3600")
     *
     * Muestra la portada de cada store, que muestra su información y las
=======
     * Muestra la portada de cada store, que muestra su información y las
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
     * ofertas que ha publicado recientemente
     *
<<<<<<< HEAD
     * @param string $city El slug de la city donde se encuentra la store
     * @param string $store El slug de la store
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
     * @param string $city El slug de la city donde se encuentra la store
     * @param string $store El slug de la store
=======
     * @Route("/{city}/tiendas/{store}", requirements={ "city" = ".+" }, name="tienda_portada")
     * @Cache(smaxage="3600")
     *
     * @param string $city El slug de la city donde se encuentra la store
     * @param string $store El slug de la store
     *
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
     * @return Response
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
    }
}
