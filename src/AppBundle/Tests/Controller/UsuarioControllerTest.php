<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Tests\Controller;

use AppBundle\Test\BaseTestCase;

/**
 * Test funcional para comprobar que funciona bien el record de usuarios
 * en el frontend, además del perfil y el proceso de baja del user.
 */
class UsuarioControllerTest extends BaseTestCase
{
    /**
     * @dataProvider usuarios
     * @param $usuario
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
    }

    /**
     * method que provee de usuarios de prueba a los tests de esta clase.
     */
    public function usuarios()
    {
        return array(
            array(
                array(
                    'frontend_usuario[name]' => 'Anónimo',
                    'frontend_usuario[apellidos]' => 'Apellido1 Apellido2',
                    'frontend_usuario[email]' => 'anonimo'.uniqid('', true).'@localhost.localdomain',
                    'frontend_usuario[passwordEnClaro][first]' => 'anonimo1234',
                    'frontend_usuario[passwordEnClaro][second]' => 'anonimo1234',
                    'frontend_usuario[direccion]' => 'Mi calle, Mi city, 01001',
                    'frontend_usuario[dni]' => '11111111H',
                    'frontend_usuario[numeroTarjeta]' => '123456789012345',
                    'frontend_usuario[city]' => '1',
                    'frontend_usuario[permiteEmail]' => '1',
                ),
            ),
        );
    }
}
