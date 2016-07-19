<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * Returns active offers as JSON.
     *
     * @Route("/offers", name="api_offers")
     */
    public function offersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ofertas = $em->getRepository('AppBundle:Oferta')
            ->findBy(['revisada' => true], ['fechaPublicacion' => 'DESC'], 20);

        $data = [];
        foreach ($ofertas as $oferta) {
            $data[] = [
                'id' => $oferta->getId(),
                'nombre' => $oferta->getNombre(),
                'descripcion' => $oferta->getDescripcion(),
                'precio' => $oferta->getPrecio(),
                'descuento' => $oferta->getDescuento(),
            ];
        }

        return new JsonResponse(['offers' => $data, 'count' => count($data)]);
    }

    /**
     * Returns active offers for a specific city.
     *
     * @Route("/offers/{city}", name="api_offers_city")
     */
    public function offersByCityAction($city)
    {
        $em = $this->getDoctrine()->getManager();
        $ciudad = $em->getRepository('AppBundle:Ciudad')
            ->findOneBy(['slug' => $city]);

        if (!$ciudad) {
            return new JsonResponse(['error' => 'City not found'], 404);
        }

        $ofertas = $em->getRepository('AppBundle:Oferta')
            ->findBy(
                ['ciudad' => $ciudad, 'revisada' => true],
                ['fechaPublicacion' => 'DESC'],
                20
            );

        $data = [];
        foreach ($ofertas as $oferta) {
            $data[] = [
                'id' => $oferta->getId(),
                'nombre' => $oferta->getNombre(),
                'precio' => $oferta->getPrecio(),
                'descuento' => $oferta->getDescuento(),
            ];
        }

        return new JsonResponse(['city' => $city, 'offers' => $data]);
    }
}
