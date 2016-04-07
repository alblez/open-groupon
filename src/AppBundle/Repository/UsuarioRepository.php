<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    /**
     * Encuentra todas las compras del user indicado.
     *
     * @param int $user El id del user
     *
     * @return array
     */
    public function findTodasLasCompras($user)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT v, o, t
            FROM AppBundle:sale v JOIN v.offer o JOIN o.store t
            WHERE v.user = :id
            ORDER BY v.date DESC
        ');
        $query->setParameter('id', $user);

        return $query->getResult();
    }
}
