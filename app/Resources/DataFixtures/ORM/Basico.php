<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\city;
use AppBundle\Entity\offer;
use AppBundle\Entity\store;
use AppBundle\Entity\user;
use AppBundle\Entity\sale;
use AppBundle\Util\Slugger;

/**
 * Versión simplificada de los fixtures completos de la application.
 * Se ha eliminado todo el code que hace uso de la ACL y del componente
 * de security.
 *
 * Este es el file que debes utilizar si estás creando la application a mano
 * y todavía no has llegado al capítulo de la security. Carga estos fixtures
 * básicos ejecutando el siguiente comando:
 *
 * $ php app/console doctrine:fixtures:load --fixtures=app/Resources
 * 
 * Al utilizar este file de datos simplificado, la configuration de security
 * de la application debe indicar que los usuarios de type `user` guardan la
 * password en claro, sin codificar.
 * 
 * Asegúrate de que en el file `security.yml` tengas la siguiente configuration:
 *   security:
 *     # ...
 *     encoders:
 *       Cupon\UsuarioBundle\Entity\user: plaintext
 */
class Basico implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Crear 5 ciudades de prueba
        foreach (array('Madrid', 'Barcelona', 'Castellón', 'Vigo', 'Vitoria-Gasteiz') as $name) {
            $city = new city();
            $city->setNombre($name);

            $manager->persist($city);
        }

        $manager->flush();

        // Crear 10 tiendas en cada city
        $ciudades = $manager->getRepository('AppBundle:city')->findAll();
        $numTienda = 0;
        foreach ($ciudades as $city) {
            for ($i = 1; $i <= 10; ++$i) {
                ++$numTienda;

                $store = new store();
                $store->setNombre('store #'.$numTienda);
                $store->setLogin('store'.$numTienda);
                $store->setPassword('password'.$numTienda);
                $store->setDescripcion(
                    'Lorem ipsum dolor sit amet, consectetur adipisicing elit,'
                    .'sed do eiusmod tempor incididunt ut labore et dolore magna'
                    .'aliqua. Ut enim ad minim veniam, quis nostrud exercitation'
                    .'ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                );
                $store->setDireccion("Calle Lorem Ipsum, $i\n".$city->getNombre());
                $store->setCiudad($city);

                $manager->persist($store);
            }
        }
        $manager->flush();

        // Crear 50 ofertas en cada city
        $ciudades = $manager->getRepository('AppBundle:city')->findAll();
        $numOferta = 0;
        foreach ($ciudades as $city) {
            $tiendas = $manager->getRepository('AppBundle:store')->findByCiudad(
                $city->getId()
            );

            for ($i = 1; $i <= 50; ++$i) {
                ++$numOferta;

                $offer = new offer();

                $offer->setNombre('offer #'.$numOferta.' lorem ipsum dolor sit amet');
                $offer->setSlug(Slugger::getSlug($offer->getNombre()));
                $offer->setDescripcion(
                    "Lorem ipsum dolor sit amet, consectetur adipisicing.\n"
                    ."Elit, sed do eiusmod tempor incididunt.\n"
                    ."Ut labore et dolore magna aliqua.\n"
                    .'Nostrud exercitation ullamco laboris nisi ut'
                );
                $offer->setCondiciones('Labore et dolore magna aliqua. Ut enim ad minim veniam.');
                $offer->setRutaFoto('photo'.rand(1, 20).'.jpg');
                $offer->setPrecio(number_format(rand(100, 10000) / 100, 2));
                $offer->setDescuento($offer->getPrecio() * (rand(10, 70) / 100));

                // Se publican 9 ofertas en el pasado, 1 en el presente y 40 en el futuro
                if (1 == $i) {
                    $date = 'today';
                    $offer->setRevisada(true);
                } elseif ($i < 10) {
                    $date = 'now - '.($i - 1).' days';
                    // el 80% de las ofertas pasadas se marcan como revisadas
                    $offer->setRevisada((rand(1, 1000) % 10) < 8);
                } else {
                    $date = 'now + '.($i - 10 + 1).' days';
                    $offer->setRevisada(true);
                }

                $fechaPublicacion = new \DateTime($date);
                $fechaPublicacion->setTime(23, 59, 59);

                $fechaExpiracion = clone $fechaPublicacion;
                $fechaExpiracion->add(\DateInterval::createFromDateString('24 hours'));

                $offer->setFechaPublicacion($fechaPublicacion);
                $offer->setFechaExpiracion($fechaExpiracion);

                $offer->setCompras(0);
                $offer->setUmbral(rand(25, 100));

                $offer->setCiudad($city);

                // Seleccionar aleatoriamente una store que pertenezca a la city
                $offer->setTienda($tiendas[array_rand($tiendas)]);

                $manager->persist($offer);
            }
        }
        $manager->flush();

        // Crear 100 usuarios en cada city
        $numUsuario = 0;
        foreach ($ciudades as $city) {
            for ($i = 1; $i <= 100; ++$i) {
                ++$numUsuario;

                $user = new user();

                $user->setNombre('user #'.$numUsuario);
                $user->setApellidos('Apellido1 Apellido2');
                $user->setEmail('user'.$numUsuario.'@localhost');
                $user->setPassword('password'.$numUsuario);
                $user->setDireccion("Calle Ipsum Lorem, 2\n".$city->getNombre());
                // El 60% de los usuarios permite email
                $user->setPermiteEmail((rand(1, 1000) % 10) < 6);
                $user->setFechaAlta(new \DateTime('now - '.rand(1, 150).' days'));
                $user->setFechaNacimiento(new \DateTime('now - '.rand(7000, 20000).' days'));

                $dni = substr(rand(), 0, 8);
                $user->setDni($dni.substr(
                    'TRWAGMYFPDXBNJZSQVHLCKE',
                    strtr($dni, 'XYZ', '012') % 23, 1)
                );

                $user->setNumeroTarjeta('1234567890123456');
                $user->setCiudad($city);

                $manager->persist($user);
            }
        }
        $manager->flush();

        // Crear 500 ventas aleatorias
        $ofertas = $manager->getRepository('AppBundle:offer')->findAll();
        $usuarios = $manager->getRepository('AppBundle:user')->findAll();

        foreach ($usuarios as $user) {
            $compras = rand(0, 10);
            $comprado = array();

            for ($i = 0; $i < $compras; ++$i) {
                $sale = new sale();

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

                $publicacion = clone $offer->getFechaPublicacion();
                $sale->setFecha(
                    $publicacion->add(\DateInterval::createFromDateString(rand(10, 10000).' seconds'))
                );

                $manager->persist($sale);

                $offer->setCompras($offer->getCompras() + 1);
                $manager->persist($offer);
            }

            unset($comprado);
        }
        $manager->flush();
    }
}
