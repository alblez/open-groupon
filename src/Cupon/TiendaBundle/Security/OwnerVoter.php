<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\TiendaBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class OwnerVoter implements VoterInterface
{
    public function supportsAttribute($attribute)
    {
        return 'ROLE_EDITAR_OFERTA' == $attribute;
    }

    public function supportsClass($class)
    {
        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $vote = VoterInterface::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if (false === $this->supportsAttribute($attribute)) {
                continue;
            }

            $user = $token->getUser();
            $vote = VoterInterface::ACCESS_DENIED;

            // comprobar que la offer que se edita fue publicada por esta misma store
            if ($object->getTienda()->getId() === $user->getId()) {
                $vote = VoterInterface::ACCESS_GRANTED;
            }
        }

        return $vote;
    }
}
