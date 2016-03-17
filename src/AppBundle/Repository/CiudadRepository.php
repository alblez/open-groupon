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

class CiudadRepository extends EntityRepository
{
    /**
     * returns un array simple con todas las ciudades disponibles
     */
    public function findListaCiudades()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT c
<<<<<<< HEAD:src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM CiudadBundle:city c
            ORDER BY c.name
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM CiudadBundle:Ciudad c
            ORDER BY c.nombre
=======
            FROM AppBundle:Ciudad c
            ORDER BY c.nombre
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Repository/CiudadRepository.php
        ');
        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }

    /**
     * Encuentra las cinco ciudades más cercanas a la city indicada
     *
     * @param string $ciudad_id El id de la city para la que se buscan cercanas
     */
    public function findCercanas($ciudad_id)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT c
<<<<<<< HEAD:src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM CiudadBundle:city c
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM CiudadBundle:Ciudad c
=======
            FROM AppBundle:Ciudad c
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Repository/CiudadRepository.php
            WHERE c.id != :id
            ORDER BY c.name ASC
        ');
        $query->setMaxResults(5);
        $query->setParameter('id', $ciudad_id);
        $query->useResultCache(true, 3600);

        return $query->getResult();
    }

    /**
     * Encuentra todas las ofertas de la city indicada
     *
     * @param string $city El slug de la city para la que se buscan sus ofertas
     */
    public function findTodasLasOfertas($city)
    {
        return $this->queryTodasLasOfertas($city)->getResult();
    }

    /**
     * method especial asociado con `findTodasLasOfertas()` y que returns solamente
     * la query necesaria para obtener todas las ofertas de la city indicada.
     * Se utiliza para la paginación de resultados.
     *
     * @param string $city El slug de la city
     */
    public function queryTodasLasOfertas($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
<<<<<<< HEAD:src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM OfertaBundle:offer o JOIN o.store t JOIN o.city c
            WHERE c.slug = :city
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM OfertaBundle:Oferta o JOIN o.tienda t JOIN o.ciudad c
            WHERE c.slug = :ciudad
=======
            FROM AppBundle:Oferta o JOIN o.tienda t JOIN o.ciudad c
            WHERE c.slug = :ciudad
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Repository/CiudadRepository.php
            ORDER BY o.fecha_publicacion DESC
        ');
        $query->setParameter('city', $city);
        $query->useResultCache(true, 600);

        return $query;
    }

    /**
     * Encuentra todos los usuarios asociados a la city indicada
     *
     * @param string $city El slug de la city para la que se buscan sus usuarios
     */
    public function findTodosLosUsuarios($city)
    {
        return $this->queryTodosLosUsuarios($city)->getResult();
    }

    /**
     * method especial asociado con `findTodosLosUsuarios()` y que returns solamente
     * la query necesaria para obtener todos los usuarios de la city indicada.
     * Se utiliza para la paginación de resultados.
     *
     * @param string $city El slug de la city
     */
    public function queryTodosLosUsuarios($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT u
            FROM UsuarioBundle:user u JOIN u.city c
            WHERE c.slug = :city
            ORDER BY u.apellidos ASC
        ');
        $query->setParameter('city', $city);

        return $query;
    }

    /**
     * Encuentra todas las tiendas asociadas a la city indicada
     *
     * @param string $city El slug de la city para la que se buscan sus tiendas
     */
    public function findTodasLasTiendas($city)
    {
        return $this->queryTodasLasTiendas($city)->getResult();
    }

    /**
     * method especial asociado con `findTodasLasTiendas()` y que returns solamente
     * la query necesaria para obtener todas las tiendas de la city indicada.
     * Se utiliza para la paginación de resultados.
     *
     * @param string $city El slug de la city
     */
    public function queryTodasLasTiendas($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT t
<<<<<<< HEAD:src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM TiendaBundle:store t JOIN t.city c
            WHERE c.slug = :city
            ORDER BY t.name ASC
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/CiudadBundle/Entity/CiudadRepository.php
            FROM TiendaBundle:Tienda t JOIN t.ciudad c
            WHERE c.slug = :ciudad
            ORDER BY t.nombre ASC
=======
            FROM AppBundle:Tienda t JOIN t.ciudad c
            WHERE c.slug = :ciudad
            ORDER BY t.nombre ASC
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Repository/CiudadRepository.php
        ');
        $query->setParameter('city', $city);
        $query->useResultCache(true, 600);

        return $query;
    }
}
