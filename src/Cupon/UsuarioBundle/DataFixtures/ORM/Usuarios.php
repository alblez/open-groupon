<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\UsuarioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Cupon\CiudadBundle\Entity\city;
use Cupon\UsuarioBundle\Entity\user;

/**
 * Fixtures de la entity user.
 * creates 200 usuarios de prueba con información muy realista.
 */
class Usuarios extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 40;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Obtener todas las ciudades de la base de datos
        $ciudades = $manager->getRepository('CiudadBundle:city')->findAll();

        for ($i=1; $i<=200; $i++) {
            $user = new user();

            $user->setNombre($this->getNombre());
            $user->setApellidos($this->getApellidos());
            $user->setEmail('user'.$i.'@localhost');

            $user->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            $passwordEnClaro = 'user'.$i;
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $user->getSalt());
            $user->setPassword($passwordCodificado);

            $city = $ciudades[array_rand($ciudades)];
            $user->setDireccion($this->getDireccion($city));
            $user->setCiudad($city);

            // El 60% de los usuarios permite email
            $user->setPermiteEmail((rand(1, 1000) % 10) < 6);

            $user->setFechaAlta(new \DateTime('now - '.rand(1, 150).' days'));
            $user->setFechaNacimiento(new \DateTime('now - '.rand(7000, 20000).' days'));

            $dni = substr(rand(), 0, 8);
            $user->setDni($dni.substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($dni, "XYZ", "012")%23, 1));

            $user->setNumeroTarjeta('1234567890123456');

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * Generador aleatorio de nombres de personas.
     * Aproximadamente genera un 50% de hombres y un 50% de mujeres.
     *
     * @return string name aleatorio generado para el user.
     */
    private function getNombre()
    {
        // Los nombres más populares en España según el INE
        // Fuente: http://www.ine.es/daco/daco42/nombyapel/nombyapel.htm

        $hombres = array(
            'Antonio', 'José', 'Manuel', 'Francisco', 'Juan', 'David',
            'José Antonio', 'José Luis', 'Jesús', 'Javier', 'Francisco Javier',
            'Carlos', 'Daniel', 'Miguel', 'Rafael', 'Pedro', 'José Manuel',
            'Ángel', 'Alejandro', 'Miguel Ángel', 'José María', 'Fernando',
            'Luis', 'Sergio', 'Pablo', 'Jorge', 'Alberto'
        );
        $mujeres = array(
            'María Carmen', 'María', 'Carmen', 'Josefa', 'Isabel', 'Ana María',
            'María Dolores', 'María Pilar', 'María Teresa', 'Ana', 'Francisca',
            'Laura', 'Antonia', 'Dolores', 'María Angeles', 'Cristina', 'Marta',
            'María José', 'María Isabel', 'Pilar', 'María Luisa', 'Concepción',
            'Lucía', 'Mercedes', 'Manuela', 'Elena', 'Rosa María'
        );

        if (rand() % 2) {
            return $hombres[array_rand($hombres)];
        } else {
            return $mujeres[array_rand($mujeres)];
        }
    }

    /**
     * Generador aleatorio de apellidos de personas.
     *
     * @return string Apellido aleatorio generado para el user.
     */
    private function getApellidos()
    {
        // Los apellidos más populares en España según el INE
        // Fuente: http://www.ine.es/daco/daco42/nombyapel/nombyapel.htm

        $apellidos = array(
            'García', 'González', 'Rodríguez', 'Fernández', 'López', 'Martínez',
            'Sánchez', 'Pérez', 'Gómez', 'Martín', 'Jiménez', 'Ruiz',
            'Hernández', 'Díaz', 'Moreno', 'Álvarez', 'Muñoz', 'Romero',
            'Alonso', 'Gutiérrez', 'Navarro', 'Torres', 'Domínguez', 'Vázquez',
            'Ramos', 'Gil', 'Ramírez', 'Serrano', 'Blanco', 'Suárez', 'Molina',
            'Morales', 'Ortega', 'Delgado', 'Castro', 'Ortíz', 'Rubio', 'Marín',
            'Sanz', 'Iglesias', 'Nuñez', 'Medina', 'Garrido'
        );

        return $apellidos[array_rand($apellidos)].' '.$apellidos[array_rand($apellidos)];
    }

    /**
     * Generador aleatorio de direcciones postales.
     *
     * @param  city $city Objeto de la city para la que se genera una address postal.
     * @return string         address postal aleatoria generada para la store.
     */
    private function getDireccion(city $city)
    {
        $prefijos = array('Calle', 'Avenida', 'Plaza');
        $nombres = array(
            'Lorem', 'Ipsum', 'Sitamet', 'Consectetur', 'Adipiscing',
            'Necsapien', 'Tincidunt', 'Facilisis', 'Nulla', 'Scelerisque',
            'Blandit', 'Ligula', 'Eget', 'Hendrerit', 'Malesuada', 'Enimsit'
        );

        return $prefijos[array_rand($prefijos)].' '.$nombres[array_rand($nombres)].', '.rand(1, 100)."\n"
               .$this->getCodigoPostal().' '.$city->getNombre();
    }

    /**
     * Generador aleatorio de códigos postales
     *
     * @return string code postal aleatorio generado para la store.
     */
    private function getCodigoPostal()
    {
        return sprintf('%02s%03s', rand(1, 52), rand(0, 999));
    }
}
