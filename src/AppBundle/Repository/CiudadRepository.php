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
     * returns un array simple con todas las ciudades disponibles.
     */
    public function findListaCiudades()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT c
            FROM AppBundle:city c
            ORDER BY c.name
        ');
        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }

    /**
     * Encuentra las cinco ciudades más cercanas a la city indicada.
     *
     * @param $ciudadId El id de la city para la que se buscan cercanas
     * @return array
     */
    public function findCercanas($ciudadId)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT c
            FROM AppBundle:city c
            WHERE c.id != :id
            ORDER BY c.name ASC
        ');
        $query->setMaxResults(5);
        $query->setParameter('id', $ciudadId);
        $query->useResultCache(true, 3600);

        return $query->getResult();
    }

    /**
     * Encuentra todas las ofertas de la city indicada.
     *
     * @param string $city El slug de la city para la que se buscan sus ofertas
     * @return array
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
     * @return \Doctrine\ORM\Query
     */
    public function queryTodasLasOfertas($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT o, t
            FROM AppBundle:offer o JOIN o.store t JOIN o.city c
            WHERE c.slug = :city
            ORDER BY o.fechaPublicacion DESC
        ');
        $query->setParameter('city', $city);
        $query->useResultCache(true, 600);

        return $query;
    }

    /**
     * Encuentra todos los usuarios asociados a la city indicada.
     *
     * @param string $city El slug de la city para la que se buscan sus usuarios
     * @return array
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
     * @return \Doctrine\ORM\Query
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
     * Encuentra todas las tiendas asociadas a la city indicada.
     *
     * @param string $city El slug de la city para la que se buscan sus tiendas
     * @return array
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
     * @return \Doctrine\ORM\Query
     */
    public function queryTodasLasTiendas($city)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT t
            FROM AppBundle:store t JOIN t.city c
            WHERE c.slug = :city
            ORDER BY t.name ASC
        ');
        $query->setParameter('city', $city);
        $query->useResultCache(true, 600);

        return $query;
    }
}
