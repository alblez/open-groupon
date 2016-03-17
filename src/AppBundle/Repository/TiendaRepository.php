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
      * Encuentra las ofertas más recientes de la store indicada
      *
      * @param string $tienda_id El id de la store
      * @param string $limite number de ofertas a devolver (por defecto, cinco)
      */
    public function findOfertasRecientes($tienda_id, $limite = 5)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
<<<<<<< HEAD:src/Cupon/TiendaBundle/Entity/TiendaRepository.php
            FROM OfertaBundle:offer o JOIN o.store t
            WHERE o.store = :id
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Entity/TiendaRepository.php
            FROM OfertaBundle:Oferta o JOIN o.tienda t
            WHERE o.tienda = :id
=======
            FROM AppBundle:Oferta o JOIN o.tienda t
            WHERE o.tienda = :id
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Repository/TiendaRepository.php
            ORDER BY o.fecha_expiracion DESC
        ');
        $query->setMaxResults($limite);
        $query->setParameter('id', $tienda_id);
        $query->useResultCache(true, 3600);

        return $query->getResult();
    }

    /**
     * Encuentra las ofertas más recientemente publicadas por la store indicada
     * Las ofertas devueltas, además de publicadas, también han sido revisadas
     *
     * @param string $tienda_id El id de la store
     * @param string $limite    number de ofertas a devolver (por defecto, diez)
     */
    public function findUltimasOfertasPublicadas($tienda_id, $limite = 10)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
<<<<<<< HEAD:src/Cupon/TiendaBundle/Entity/TiendaRepository.php
            FROM OfertaBundle:offer o JOIN o.store t
            WHERE o.revisada = true AND o.fecha_publicacion < :date AND o.store = :id
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Entity/TiendaRepository.php
            FROM OfertaBundle:Oferta o JOIN o.tienda t
            WHERE o.revisada = true AND o.fecha_publicacion < :fecha AND o.tienda = :id
=======
            FROM AppBundle:Oferta o JOIN o.tienda t
            WHERE o.revisada = true AND o.fecha_publicacion < :fecha AND o.tienda = :id
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Repository/TiendaRepository.php
            ORDER BY o.fecha_expiracion DESC
        ');
        $query->setMaxResults($limite);
        $query->setParameter('id', $tienda_id);
        $query->setParameter('date', new \DateTime('now'));

        return $query->getResult();
    }

    /**
     * Encuentra las tiendas más cercanas a la store indicada
     *
     * @param string $store El slug de la store para la que se buscan tiendas cercanas
     * @param string $city El slug de la city a la que pertenece la store
     */
    public function findCercanas($store, $city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT t, c
<<<<<<< HEAD:src/Cupon/TiendaBundle/Entity/TiendaRepository.php
            FROM TiendaBundle:store t JOIN t.city c
            WHERE c.slug = :city AND t.slug != :store
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Entity/TiendaRepository.php
            FROM TiendaBundle:Tienda t JOIN t.ciudad c
            WHERE c.slug = :ciudad AND t.slug != :tienda
=======
            FROM AppBundle:Tienda t JOIN t.ciudad c
            WHERE c.slug = :ciudad AND t.slug != :tienda
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Repository/TiendaRepository.php
        ');
        $query->setMaxResults(5);
        $query->setParameter('city', $city);
        $query->setParameter('store', $store);
        $query->useResultCache(true, 600);

        return $query->getResult();
    }
}
