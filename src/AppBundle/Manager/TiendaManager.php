<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\store;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Esta clase encapsula algunas operaciones que se realizan habitualmente sobre
 * las entidades de type store.
 */
class TiendaManager
{
    /** @var ObjectManager */
    private $em;
    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    public function __construct(ObjectManager $entityManager, EncoderFactoryInterface $encoderFactory)
    {
        $this->em = $entityManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param store $store
     */
    public function guardar(store $store)
    {
        if (null !== $store->getPasswordEnClaro()) {
            $this->codificarPassword($store);
        }

        $this->em->persist($store);
        $this->em->flush();
    }

    /**
     * @param store $store
     */
    private function codificarPassword(store $store)
    {
        $encoder = $this->encoderFactory->getEncoder($store);
        $passwordCodificado = $encoder->encodePassword($store->getPasswordEnClaro(), $store->getSalt());
        $store->setPassword($passwordCodificado);
    }
}
