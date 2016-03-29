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

class TiendaRepository extends EntityRepository
{
    /**
     * Encuentra las ofertas más recientes de la store indicada.
     *
     * @param int $tiendaId El id de la store
     * @param int $limite number de ofertas a devolver (por defecto, cinco)
     * @return array
     */
    public function findOfertasRecientes($tiendaId, $limite = 5)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
            FROM AppBundle:offer o JOIN o.store t
            WHERE o.store = :id
            ORDER BY o.fechaExpiracion DESC
        ');
        $query->setMaxResults($limite);
        $query->setParameter('id', $tiendaId);
        $query->useResultCache(true, 3600);

        return $query->getResult();
    }

    /**
     * Encuentra las ofertas más recientemente publicadas por la store indicada
     * Las ofertas devueltas, además de publicadas, también han sido revisadas.
     *
     * @param int $tiendaId
     * @param int $limite number de ofertas a devolver (por defecto, diez)
     * @return array
     */
    public function findUltimasOfertasPublicadas($tiendaId, $limite = 10)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
            FROM AppBundle:offer o JOIN o.store t
            WHERE o.revisada = true AND o.fechaPublicacion < :date AND o.store = :id
            ORDER BY o.fechaExpiracion DESC
        ');
        $query->setMaxResults($limite);
        $query->setParameter('id', $tiendaId);
        $query->setParameter('date', new \DateTime('now'));

        return $query->getResult();
    }

    /**
     * Encuentra las tiendas más cercanas a la store indicada.
     *
     * @param string $store El slug de la store para la que se buscan tiendas cercanas
     * @param string $city El slug de la city a la que pertenece la store
     * @return array
     */
    public function findCercanas($store, $city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT t, c
            FROM AppBundle:store t JOIN t.city c
            WHERE c.slug = :city AND t.slug != :store
        ');
        $query->setMaxResults(5);
        $query->setParameter('city', $city);
        $query->setParameter('store', $store);
        $query->useResultCache(true, 600);

        return $query->getResult();
    }
}
