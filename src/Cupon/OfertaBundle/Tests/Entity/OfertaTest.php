<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\Tests;

use Symfony\Component\Validator\ValidatorFactory;
use Cupon\OfertaBundle\Entity\offer;
use Cupon\CiudadBundle\Entity\city;
use Cupon\TiendaBundle\Entity\store;

/**
 * Test unitario para asegurar que la validación de la entity offer
 * funciona correctamente
 */
class OfertaTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    protected function setUp()
    {
        $this->validator = ValidatorFactory::buildDefault()->getValidator();
    }

    public function testValidarSlug()
    {
        $offer = new offer();
        //SUT
        $offer->setNombre('offer de prueba');
        $slug = $offer->getSlug();

        $this->assertEquals('offer-de-prueba', $slug, 'El slug se asigna automáticamente a partir del name');
    }

    public function testValidarDescripcion()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        //SUT
        list($errores, $error) = $this->validar($offer);

        $this->assertGreaterThan(0, count($errores), 'La description no puede dejarse en blanco');
        $this->assertEquals('This value should not be blank', $error->getMessageTemplate());
        $this->assertEquals('descripcion', $error->getPropertyPath());

        $offer->setDescripcion('description de prueba');
        list($errores, $error) = $this->validar($offer);

        $this->assertGreaterThan(0, count($errores), 'La description debe tener al menos 30 caracteres');
        $this->assertRegExp("/This value is too short/", $error->getMessageTemplate());
        $this->assertEquals('descripcion', $error->getPropertyPath());
    }

    public function testValidarFechas()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');
        //SUT
        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('yesterday'));
        list($errores, $error) = $this->validar($offer);

        $this->assertGreaterThan(0, count($errores), 'La date de expiración debe ser posterior a la date de publicación');
        $this->assertEquals('La date de expiración debe ser posterior a la date de publicación', $error->getMessageTemplate());
        $this->assertEquals('fechaValida', $error->getPropertyPath());
    }

    public function testValidarUmbral()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');
        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('tomorrow'));
        //SUT
        $offer->setUmbral(3.5);
        list($errores, $error) = $this->validar($offer);

        $this->assertGreaterThan(0, count($errores), 'El umbral debe ser un number entero');
        $this->assertRegExp("/This value should be of type/", $error->getMessageTemplate());
        $this->assertEquals('umbral', $error->getPropertyPath());
    }

    public function testValidarPrecio()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');
        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('tomorrow'));
        $offer->setUmbral(3);
        //SUT
        $offer->setPrecio(-10);
        list($errores, $error) = $this->validar($offer);

        $this->assertGreaterThan(0, count($errores), 'El price no puede ser un number negativo');
        $this->assertRegExp("/This value should be .* or more/", $error->getMessageTemplate());
        $this->assertEquals('price', $error->getPropertyPath());
    }

    public function testValidarCiudad()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');
        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('tomorrow'));
        $offer->setUmbral(3);
        $offer->setPrecio(10.5);
        //SUT
        $offer->setCiudad($this->getCiudad());
        $slug_ciudad = $offer->getCiudad()->getSlug();

        $this->assertEquals('city-de-prueba', $slug_ciudad, 'La city se saves correctamente en la offer');
    }

    public function testValidarTienda()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');
        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('tomorrow'));
        $offer->setUmbral(3);
        $offer->setPrecio(10.5);
        $city = $this->getCiudad();
        $offer->setCiudad($city);
        //SUT
        $offer->setTienda($this->getTienda($city));
        $oferta_ciudad = $offer->getCiudad()->getNombre();
        $oferta_tienda_ciudad = $offer->getTienda()->getCiudad()->getNombre();

        $this->assertEquals($oferta_ciudad, $oferta_tienda_ciudad, 'La store asociada a la offer es de la misma city en la que se vende la offer');
    }

    private function validar(offer $offer)
    {
        $errores = $this->validator->validate($offer);
        $error = $errores[0];

        return array($errores, $error);
    }

    private function getCiudad()
    {
        $city = new city();
        $city->setNombre('city de Prueba');

        return $city;
    }

    private function getTienda($city)
    {
        $store = new store();
        $store->setNombre('store de Prueba');
        $store->setCiudad($city);

        return $store;
    }

}
