<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\offer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures de la entity offer.
 * creates para cada city 15 ofertas con información muy realista.
 */
class Ofertas extends AbstractFixture implements OrderedFixtureInterface
{
    const NUM_OFERTAS = 15;

    public function getOrder()
    {
        return 30;
    }

    public function load(ObjectManager $manager)
    {
        // Obtener todas las tiendas y ciudades de la base de datos
        $ciudades = $manager->getRepository('AppBundle:city')->findAll();
        $tiendas = $manager->getRepository('AppBundle:store')->findAll();

        foreach ($ciudades as $city) {
            $tiendas = $manager->getRepository('AppBundle:store')->findByCiudad(
                $city->getId()
            );

            for ($j = 1; $j <= self::NUM_OFERTAS; ++$j) {
                $offer = new offer();

                $offer->setNombre($this->getNombre());
                $offer->setDescripcion($this->getDescripcion());
                $offer->setCondiciones($this->getCondiciones());
                $offer->setRutaFoto('photo'.rand(1, 20).'.jpg');
                $offer->setPrecio(number_format(rand(100, 10000) / 100, 2));
                $offer->setDescuento($offer->getPrecio() * (rand(10, 70) / 100));

                // Una offer se publica hoy, el resto se reparte entre el pasado y el futuro
                if (1 == $j) {
                    $date = 'today';
                    $offer->setRevisada(true);
                } elseif ($j < 10) {
                    $date = 'now - '.($j - 1).' days';
                    // el 80% de las ofertas pasadas se marcan como revisadas
                    $offer->setRevisada((rand(1, 1000) % 10) < 8);
                } else {
                    $date = 'now + '.($j - 10 + 1).' days';
                    $offer->setRevisada(true);
                }

                $fechaPublicacion = new \DateTime($date);
                $fechaPublicacion->setTime(23, 59, 59);

                // Se debe clonar el value de la fechaPublicacion porque si se usa directamente
                // el method ->add(), se modificaría el value original, que no se saves en la BD
                // hasta que se hace el ->flush()
                $fechaExpiracion = clone $fechaPublicacion;
                $fechaExpiracion->add(\DateInterval::createFromDateString('24 hours'));

                $offer->setFechaPublicacion($fechaPublicacion);
                $offer->setFechaExpiracion($fechaExpiracion);

                $offer->setCompras(0);
                $offer->setUmbral(rand(25, 100));

                $offer->setCiudad($city);

                // Seleccionar aleatoriamente una store que pertenezca a la city anterior
                $store = $tiendas[array_rand($tiendas)];
                $offer->setTienda($store);

                $manager->persist($offer);
                $manager->flush();
            }
        }
    }

    /**
     * Generador aleatorio de nombres de ofertas.
     *
     * @return string name/título aletorio generado para la offer.
     */
    private function getNombre()
    {
        $palabras = array_flip(array(
            'Lorem', 'Ipsum', 'Sitamet', 'Et', 'At', 'Sed', 'Aut', 'Vel', 'Ut',
            'Dum', 'Tincidunt', 'Facilisis', 'Nulla', 'Scelerisque', 'Blandit',
            'Ligula', 'Eget', 'Drerit', 'Malesuada', 'Enimsit', 'Libero',
            'Penatibus', 'Imperdiet', 'Pendisse', 'Vulputae', 'Natoque',
            'Aliquam', 'Dapibus', 'Lacinia',
        ));

        $numeroPalabras = rand(4, 8);

        return implode(' ', array_rand($palabras, $numeroPalabras));
    }

    /**
     * Generador aleatorio de descripciones de ofertas.
     *
     * @return string description aletoria generada para la offer.
     */
    private function getDescripcion()
    {
        $frases = array_flip(array(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Mauris ultricies nunc nec sapien tincidunt facilisis.',
            'Nulla scelerisque blandit ligula eget hendrerit.',
            'Sed malesuada, enim sit amet ultricies semper, elit leo lacinia massa, in tempus nisl ipsum quis libero.',
            'Aliquam molestie neque non augue molestie bibendum.',
            'Pellentesque ultricies erat ac lorem pharetra vulputate.',
            'Donec dapibus blandit odio, in auctor turpis commodo ut.',
            'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
            'Nam rhoncus lorem sed libero hendrerit accumsan.',
            'Maecenas non erat eu justo rutrum condimentum.',
            'Suspendisse leo tortor, tempus in lacinia sit amet, varius eu urna.',
            'Phasellus eu leo tellus, et accumsan libero.',
            'Pellentesque fringilla ipsum nec justo tempus elementum.',
            'Aliquam dapibus metus aliquam ante lacinia blandit.',
            'Donec ornare lacus vitae dolor imperdiet vitae ultricies nibh congue.',
        ));

        $numeroFrases = rand(4, 7);

        return implode("\n", array_rand($frases, $numeroFrases));
    }

    /**
     * Generador aleatorio de condiciones de ofertas.
     *
     * @return string Condiciones aletorias generadas para la offer.
     */
    private function getCondiciones()
    {
        $condiciones = '';

        $frases = array_flip(array(
            'Máximo 1 consumición por persona.',
            'No acumulable a otras ofertas.',
            'No disponible para llevar. Debe consumirse en el propio local.',
            'Válido para cualquier día entre semana.',
            'No válido en festivos ni fines de semana.',
            'Reservado el derecho de admisión.',
            'offer válida si se realizan consumiciones adicionales por value de 50 euros.',
            'Válido solamente para comidas, no para cenas.',
        ));

        $numeroFrases = rand(2, 4);

        return implode(' ', array_rand($frases, $numeroFrases));
    }
}
