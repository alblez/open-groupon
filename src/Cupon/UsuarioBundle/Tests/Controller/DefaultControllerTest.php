<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\UsuarioBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test funcional para comprobar que funciona bien el record de usuarios
 * en el frontend, además del perfil y el proceso de baja del user
 */
class DefaultControllerTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @dataProvider usuarios
     */
    public function testRegistroPerfilBaja($user)
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/');

        // Registrarse como nuevo user
        $enlaceRegistro = $crawler->selectLink('Regístrate ya')->link();
        $crawler = $client->click($enlaceRegistro);
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Regístrate gratis como user")')->count(),
            'Después de pulsar el botón Regístrate de la portada, se carga la page con el form de record'
        );

        // Cuando se cargan los archivos de fixtures, el atributo 'id' asignado
        // a cada city es un value que se autoincrementa. Si la base de datos
        // resetea este contador cada vez, los 'id' de las ciudades seran 1, 2, 3, ...
        // Si no se resetean, no es posible saber cuál será el 'id' valido de alguna city
        // Por ello, se utiliza el siguiente truco:
        //   1. Se gets el campo de form que permite elegir la city
        //   2. Se extraen todos los valores de la lista <select>
        //   3. Se escoge la city en la posición [1] del array de ciudades, ya que la
        //      posición [0] suele estar vacía o muestra un message al user
        $listaDesplegable = $crawler
            ->selectButton('Registrarme')
            ->form()
            ->get("frontend_usuario[city]")
        ;
        $atributosIdCiudades = $listaDesplegable->availableOptionValues();
        $idValidoCiudad = $atributosIdCiudades[1];
        $user['frontend_usuario[city]'] = $idValidoCiudad;

        $form = $crawler->selectButton('Registrarme')->form($user);
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isSuccessful());

        // Comprobar que el cliente ahora dispone de una cookie de sesión
        $this->assertRegExp('/(\d|[a-z])+/', $client->getCookieJar()->get('MOCKSESSID', '/', 'localhost')->getValue(),
            'La application ha enviado una cookie de sesión'
        );

        // Acceder al perfil del user recién creado
        $perfil = $crawler->filter('aside section#login')->selectLink('Ver mi perfil')->link();
        $crawler = $client->click($perfil);

        $this->assertEquals(
            $user['frontend_usuario[email]'],
            $crawler->filter('form input[name="frontend_usuario[email]"]')->attr('value'),
            'El user se ha registrado correctamente y sus datos se han guardado en la base de datos'
        );

        // Dar de baja al user aleatorio recién creado
        $user = $this->em->getRepository('UsuarioBundle:user')->findOneByEmail($user['frontend_usuario[email]']);
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * method que provee de usuarios de prueba a los tests de esta clase
     */
    public function usuarios()
    {
        return array(
            array(
                array(
                    'frontend_usuario[name]'           => 'Anónimo',
                    'frontend_usuario[apellidos]'        => 'Apellido1 Apellido2',
                    'frontend_usuario[email]'            => 'anonimo'.uniqid().'@localhost.localdomain',
                    'frontend_usuario[password][first]'  => 'anonimo1234',
                    'frontend_usuario[password][second]' => 'anonimo1234',
                    'frontend_usuario[direccion]'        => 'Mi calle, Mi city, 01001',
                    'frontend_usuario[dni]'              => '11111111H',
                    'frontend_usuario[numero_tarjeta]'   => '123456789012345',
                    'frontend_usuario[city]'           => '1',
                    'frontend_usuario[permite_email]'    => '1'
                )
            )
        );
    }
}
