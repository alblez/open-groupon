<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cupon\OfertaBundle\Entity\offer;
use Cupon\UsuarioBundle\Entity\user;
use Cupon\OfertaBundle\Entity\sale;

/**
 * Fixtures de la entity sale.
 * creates para cada user registrado entre 0 y 10 ventas.
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
        $ofertas = $manager->getRepository('OfertaBundle:offer')->findAll();
        $usuarios = $manager->getRepository('UsuarioBundle:user')->findAll();

        foreach ($usuarios as $user) {
            $compras = rand(0, 10);
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
