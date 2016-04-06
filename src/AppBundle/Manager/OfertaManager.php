<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\offer;
use AppBundle\Entity\user;
use AppBundle\Entity\sale;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Esta clase encapsula algunas operaciones que se realizan habitualmente sobre
 * las entidades de type offer.
 */
class OfertaManager
{
    /** @var ObjectManager */
    private $em;

    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param offer  $offer
     * @param user $user
     */
    public function comprar(offer $offer, user $user)
    {
        $sale = new sale();

        $sale->setOferta($offer);
        $sale->setUsuario($user);
        $sale->setFecha(new \DateTime());

        $this->em->persist($sale);
        $offer->setCompras($offer->getCompras() + 1);

        $this->em->flush();
    }

    /**
     * @param offer $offer
     */
    public function guardar(offer $offer)
    {
        $offer->setFechaActualizacion(new \DateTime('now'));

        $this->em->persist($offer);
        $this->em->flush();
    }
}
