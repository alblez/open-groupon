<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\offer;
use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository
{
    /**
     * Encuentra la offer cuyo slug y city coinciden con los indicados.
     *
     * @param string $city El slug de la city
     * @param string $slug   El slug de la offer
     *
     * @return offer|null
     */
    public function findOferta($city, $slug)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c, t
            FROM AppBundle:offer o JOIN o.city c JOIN o.store t
            WHERE o.revisada = true AND o.slug = :slug AND c.slug = :city
        ');
        $query->setParameter('slug', $slug);
        $query->setParameter('city', $city);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    /**
     * Encuentra la offer del día en la city indicada.
     *
     * @param string $city El slug de la city
     *
     * @return offer|null
     */
    public function findOfertaDelDia($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c, t
            FROM AppBundle:offer o JOIN o.city c JOIN o.store t
            WHERE o.revisada = true AND o.fechaPublicacion < :date AND c.slug = :city
            ORDER BY o.fechaPublicacion DESC
        ');
        $query->setParameter('date', new \DateTime('now'));
        $query->setParameter('city', $city);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    /**
     * Encuentra la offer del día de mañana en la city indicada.
     *
     * @param string $city El slug de la city
     *
     * @return offer|null
     */
    public function findOfertaDelDiaSiguiente($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c, t
            FROM AppBundle:offer o JOIN o.city c JOIN o.store t
            WHERE o.revisada = true AND o.fechaPublicacion < :date AND c.slug = :city
            ORDER BY o.fechaPublicacion DESC
        ');
        $query->setParameter('date', new \DateTime('tomorrow'));
        $query->setParameter('city', $city);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    /**
     * Encuentra las cinco ofertas más recuentes de la city indicada.
     *
     * @param int $ciudad_id El id de la city
     *
     * @return array
     */
    public function findRecientes($ciudadId)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
            FROM AppBundle:offer o JOIN o.store t
            WHERE o.revisada = true AND o.fechaPublicacion < :date AND o.city = :id
            ORDER BY o.fechaPublicacion DESC
        ');
        $query->setMaxResults(5);
        $query->setParameter('id', $ciudadId);
        $query->setParameter('date', new \DateTime('today'));
        $query->useResultCache(true, 600);

        return $query->getResult();
    }

    /**
     * Encuentra las cinco ofertas más cercanas a la city indicada.
     *
     * @param string $city El slug de la city
     *
     * @return array
     */
    public function findCercanas($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c
            FROM AppBundle:offer o JOIN o.city c
            WHERE o.revisada = true AND o.fechaPublicacion <= :date AND c.slug != :city
            ORDER BY o.fechaPublicacion DESC
        ');
        $query->setMaxResults(5);
        $query->setParameter('city', $city);
        $query->setParameter('date', new \DateTime('today'));
        $query->useResultCache(true, 600);

        return $query->getResult();
    }

    /**
     * Encuentra todas las ventas de la offer indicada.
     *
     * @param int $offer El id de la offer
     *
     * @return array
     */
    public function findVentasByOferta($offer)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT v, o, u
            FROM AppBundle:sale v JOIN v.offer o JOIN v.user u
            WHERE o.id = :id
            ORDER BY v.date DESC
        ');
        $query->setParameter('id', $offer);

        return $query->getResult();
    }
}
