<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\DataFixtures\ORM;

<<<<<<< HEAD
use AppBundle\Entity\offer;
use AppBundle\Entity\sale;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * creates los datos de prueba para la entity sale.
 */
class Ventas extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 50;
    }

    public function load(ObjectManager $manager)
    {
        // Obtener todas las ofertas y usuarios de la base de datos
        $ofertas = $manager->getRepository('AppBundle:offer')->findAll();
        $usuarios = $manager->getRepository('AppBundle:user')->findAll();

        foreach ($usuarios as $user) {
            $compras = mt_rand(0, 3);
            $comprado = array();

            for ($i = 0; $i < $compras; ++$i) {
                $sale = new sale();

                $sale->setFecha(new \DateTime('now - '.mt_rand(0, 250).' hours'));

                // Sólo se añade una sale:
                //   - si este mismo user no ha comprado antes la misma offer
                //   - si la offer seleccionada ha sido revisada
                //   - si la date de publicación de la offer es posterior a ahora mismo
                $offer = $ofertas[array_rand($ofertas)];
                while (in_array($offer->getId(), $comprado)
                       || $offer->getRevisada() === false
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
=======
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
<<<<<<<< HEAD:src/Cupon/OfertaBundle/DataFixtures/ORM/Ventas.php
use Cupon\OfertaBundle\Entity\offer;
use Cupon\UsuarioBundle\Entity\user;
use Cupon\OfertaBundle\Entity\sale;
|||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/DataFixtures/ORM/Ventas.php
use Cupon\OfertaBundle\Entity\Oferta;
use Cupon\UsuarioBundle\Entity\Usuario;
use Cupon\OfertaBundle\Entity\Venta;
========
use AppBundle\Entity\Oferta;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Venta;
>>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/DataFixtures/ORM/Ventas.php

/**
 * Fixtures de la entity sale.
 * creates para cada user registrado entre 0 y 3 ventas.
 */
class Ventas extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 50;
    }

    public function load(ObjectManager $manager)
    {
        // Obtener todas las ofertas y usuarios de la base de datos
<<<<<<<< HEAD:src/Cupon/OfertaBundle/DataFixtures/ORM/Ventas.php
        $ofertas = $manager->getRepository('OfertaBundle:offer')->findAll();
        $usuarios = $manager->getRepository('UsuarioBundle:user')->findAll();
|||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/DataFixtures/ORM/Ventas.php
        $ofertas = $manager->getRepository('OfertaBundle:Oferta')->findAll();
        $usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findAll();
========
        $ofertas = $manager->getRepository('AppBundle:Oferta')->findAll();
        $usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findAll();
>>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/DataFixtures/ORM/Ventas.php

        foreach ($usuarios as $user) {
            $compras = rand(0, 3);
            $comprado = array();

            for ($i=0; $i<$compras; $i++) {
                $sale = new sale();

                $sale->setFecha(new \DateTime('now - '.rand(0, 250).' hours'));

                // Sólo se añade una sale:
                //   - si este mismo user no ha comprado antes la misma offer
                //   - si la offer seleccionada ha sido revisada
                //   - si la date de publicación de la offer es posterior a ahora mismo
                $offer = $ofertas[array_rand($ofertas)];
                while (in_array($offer->getId(), $comprado)
                       || $offer->getRevisada() == false
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
                       || $offer->getFechaPublicacion() > new \DateTime('now')) {
                    $offer = $ofertas[array_rand($ofertas)];
                }
                $comprado[] = $offer->getId();

                $sale->setOferta($offer);
                $sale->setUsuario($user);

                $manager->persist($sale);

                $offer->setCompras($offer->getCompras() + 1);
                $manager->persist($offer);
            }

            unset($comprado);
        }

        $manager->flush();
    }
}
