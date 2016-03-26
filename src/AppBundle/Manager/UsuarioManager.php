<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\user;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UsuarioManager
{
    private $em;
    private $encoderFactory;
    private $tokenStorage;

    public function __construct(ObjectManager $entityManager, EncoderFactoryInterface $encoderFactory, TokenStorageInterface $tokenStorage)
    {
        $this->em = $entityManager;
        $this->encoderFactory = $encoderFactory;
        $this->tokenStorage = $tokenStorage;
    }

    public function guardar(user $user)
    {
        if (null !== $user->getPasswordEnClaro()) {
            $this->codificarPassword($user);
        }

        $this->em->persist($user);
        $this->em->flush();
    }
    
    public function loguear(user $user)
    {
        $token = new UsernamePasswordToken($user, null, 'frontend', $user->getRoles());
        $this->tokenStorage->setToken($token);
    }

    private function codificarPassword(user $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        $passwordCodificado = $encoder->encodePassword($user->getPasswordEnClaro(), $user->getSalt());
        $user->setPassword($passwordCodificado);
    }
}
