<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository
{
    /**
     * Encuentra la offer cuyo slug y city coinciden con los indicados
     *
     * @param string $city El slug de la city
     * @param string $slug   El slug de la offer
     */
    public function findOferta($city, $slug)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c, t
            FROM OfertaBundle:offer o JOIN o.city c JOIN o.store t
            WHERE o.revisada = true AND o.slug = :slug AND c.slug = :city
        ');
        $query->setParameter('slug', $slug);
        $query->setParameter('city', $city);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    /**
     * Encuentra la offer del día en la city indicada
     *
     * @param string $city El slug de la city
     */
    public function findOfertaDelDia($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c, t
            FROM OfertaBundle:offer o JOIN o.city c JOIN o.store t
            WHERE o.revisada = true AND o.fecha_publicacion < :date AND c.slug = :city
            ORDER BY o.fecha_publicacion DESC
        ');
        $query->setParameter('date', new \DateTime('now'));
        $query->setParameter('city', $city);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    /**
     * Encuentra la offer del día de mañana en la city indicada
     *
     * @param string $city El slug de la city
     */
    public function findOfertaDelDiaSiguiente($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c, t
            FROM OfertaBundle:offer o JOIN o.city c JOIN o.store t
            WHERE o.revisada = true AND o.fecha_publicacion < :date AND c.slug = :city
            ORDER BY o.fecha_publicacion DESC
        ');
        $query->setParameter('date', new \DateTime('tomorrow'));
        $query->setParameter('city', $city);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    /**
     * Encuentra las cinco ofertas más recuentes de la city indicada
     *
     * @param string $ciudad_id El id de la city
     */
    public function findRecientes($ciudad_id)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
            FROM OfertaBundle:offer o JOIN o.store t
            WHERE o.revisada = true AND o.fecha_publicacion < :date AND o.city = :id
            ORDER BY o.fecha_publicacion DESC
        ');
        $query->setMaxResults(5);
        $query->setParameter('id', $ciudad_id);
        $query->setParameter('date', new \DateTime('today'));
        $query->useResultCache(true, 600);

        return $query->getResult();
    }

    /**
     * Encuentra las cinco ofertas más cercanas a la city indicada
     *
     * @param string $city El slug de la city
     */
    public function findCercanas($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, c
            FROM OfertaBundle:offer o JOIN o.city c
            WHERE o.revisada = true AND o.fecha_publicacion <= :date AND c.slug != :city
            ORDER BY o.fecha_publicacion DESC
        ');
        $query->setMaxResults(5);
        $query->setParameter('city', $city);
        $query->setParameter('date', new \DateTime('today'));
        $query->useResultCache(true, 600);

        return $query->getResult();
    }

    /**
     * Encuentra todas las ventas de la offer indicada
     *
     * @param string $offer El id de la offer
     */
    public function findVentasByOferta($offer)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT v, o, u
            FROM OfertaBundle:sale v JOIN v.offer o JOIN v.user u
            WHERE o.id = :id
            ORDER BY v.date DESC
        ');
        $query->setParameter('id', $offer);

        return $query->getResult();
    }
}
