<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Security;

use AppBundle\Entity\offer;
use AppBundle\Entity\store;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Este voter decide si la offer puede ser editada por la store actualmente logueada.
 */
class CreadorOfertaVoter extends Voter
{
    public function supports($attribute, $subject)
    {
        return $subject instanceof offer && 'ROLE_EDITAR_OFERTA' === $attribute;
    }

    /**
     * returns 'true' si el user logueado es de type store y es el creador
     * de la offer que se quiere modificar.
     *
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $store = $token->getUser();

        return $store instanceof store && $subject->getTienda()->getId() === $store->getId();
    }
}
