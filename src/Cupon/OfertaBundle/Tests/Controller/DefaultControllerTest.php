<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test funcional de la portada del sitio y de la acción de comprar una offer
 * por parte de un user anónimo.
 *
 * También asegura el rendimiento de la application obligando a que la portada
 * requiera menos de cuatro consultas a la base de datos y se genere en menos
 * de medio segundo.
 */
class DefaultControllerTest extends WebTestCase
{
    /** @test */
    public function laPortadaSimpleRedirigeAUnaCiudad()
    {
        $client = static::createClient();
        //SUT
        $crawler = $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode(),
            'La portada redirige a la portada de una city (status 302)'
        );
    }

    /** @test */
    public function laPortadaSoloMuestraUnaOfertaActiva()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $crawler = $client->followRedirect();
        //SUT
        $ofertasActivas = $crawler->filter(
            'article.offer section.descripcion a:contains("Comprar")'
        )->count();

        $this->assertEquals(1, $ofertasActivas,
            'La portada muestra una única offer activa que se puede comprar'
        );
    }

    /** @test */
    public function losUsuariosPuedenRegistrarseDesdeLaPortada()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $crawler = $client->followRedirect();
        //SUT
        $numeroEnlacesRegistrarse = $crawler->filter('html:contains("Regístrate")')->count();

        $this->assertGreaterThan(0, $numeroEnlacesRegistrarse,
            'La portada muestra al menos un enlace o botón para registrarse'
        );
    }

    /** @test */
    public function losUsuariosAnonimosVenLaCiudadPorDefecto()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $crawler = $client->followRedirect();
        //SUT
        $ciudadPorDefecto = $client->getContainer()->getParameter('cupon.ciudad_por_defecto');
        $ciudadPortada = $crawler->filter('header nav select option[selected="selected"]')->attr('value');

        $this->assertEquals($ciudadPorDefecto, $ciudadPortada,
            'La city seleccionada en la portada de un user anónimo es la city por defecto'
        );
    }

    /** @test */
    public function losUsuariosAnonimosNoPuedenComprar()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $crawler = $client->followRedirect();
        //SUT
        $comprar = $crawler->selectLink('Comprar')->link();
        $client->click($comprar);

        $this->assertTrue($client->getResponse()->isRedirect(),
            'Cuando un user anónimo intenta comprar, se le redirige al form de login'
        );
    }

    /** @test */
    public function losUsuariosAnonimosDebenLoguearseParaPoderComprar()
    {
        $pathLogin = '/.*\/user\/login_check/';
        $client = static::createClient();
        $client->request('GET', '/');
        $crawler = $client->followRedirect();
        //SUT
        $comprar = $crawler->selectLink('Comprar')->link();
        $client->click($comprar);
        $crawler = $client->followRedirect();

        $this->assertRegExp($pathLogin, $crawler->filter('article form')->attr('action'),
            'Después de pulsar el botón de comprar, el user anónimo ve el form de login'
        );
    }

    /** @test */
    public function laPortadaRequierePocasConsultasDeBaseDeDatos()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        //SUT
        if ($profiler = $client->getProfile()) {
            $this->assertLessThan(4, count($profiler->getCollector('db')->getQueries()),
                'La portada requiere menos de 4 consultas a la base de datos'
            );
        }
    }

    /** @test */
    public function laPortadaSeGeneraMuyRapido()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        if ($profiler = $client->getProfile()) {
            // 500 es el tiempo en milisegundos
            $this->assertLessThan(500, $profiler->getCollector('time')->getTotalTime(),
                'La portada se genera en menos de medio segundo'
            );
        }
    }
}
