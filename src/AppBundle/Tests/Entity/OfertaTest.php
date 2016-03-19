<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Tests;

<<<<<<< HEAD
use AppBundle\Entity\city;
use AppBundle\Entity\offer;
use AppBundle\Entity\store;
use Symfony\Component\Validator\Validation;

/**
 * Test unitario para asegurar que la validación de la entity offer
 * funciona correctamente.
 */
class OfertaTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    protected function setUp()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    public function testValidarSlug()
    {
        $offer = new offer();

        $offer->setNombre('offer de prueba');
        $slug = $offer->getSlug();

        $this->assertEquals('offer-de-prueba', $slug, 'El slug se asigna automáticamente a partir del name');
    }

    public function testValidarDescripcion()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'La description no puede dejarse en blanco');

        $error = $listaErrores[0];
        $this->assertEquals('This value should not be blank.', $error->getMessage());
        $this->assertEquals('descripcion', $error->getPropertyPath());

        $offer->setDescripcion('description de prueba');

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'La description debe tener al menos 30 caracteres');

        $error = $listaErrores[0];
        $this->assertRegExp('/This value is too short/', $error->getMessage());
        $this->assertEquals('descripcion', $error->getPropertyPath());
    }

    public function testValidarFechas()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');

        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('yesterday'));

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'La date de expiración debe ser posterior a la date de publicación');

        $error = $listaErrores[0];
        $this->assertEquals('La date de expiración debe ser posterior a la date de publicación', $error->getMessage());
        $this->assertEquals('fechaValida', $error->getPropertyPath());
    }

    public function testValidarUmbral()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');
        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('tomorrow'));

        $offer->setUmbral(3.5);

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'El umbral debe ser un number entero');

        $error = $listaErrores[0];
        $this->assertRegExp('/This value should be of type/', $error->getMessage());
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

        $offer->setPrecio(-10);

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'El price no puede ser un number negativo');

        $error = $listaErrores[0];
        $this->assertRegExp('/This value should be .* or more/', $error->getMessageTemplate());
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

        $offer->setTienda($this->getTienda($city));
        $oferta_ciudad = $offer->getCiudad()->getNombre();
        $oferta_tienda_ciudad = $offer->getTienda()->getCiudad()->getNombre();

        $this->assertEquals($oferta_ciudad, $oferta_tienda_ciudad, 'La store asociada a la offer es de la misma city en la que se vende la offer');
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
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
=======
use Symfony\Component\Validator\Validation;
<<<<<<<< HEAD:src/Cupon/OfertaBundle/Tests/Entity/OfertaTest.php
use Cupon\OfertaBundle\Entity\offer;
use Cupon\CiudadBundle\Entity\city;
use Cupon\TiendaBundle\Entity\store;
|||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Tests/Entity/OfertaTest.php
use Cupon\OfertaBundle\Entity\Oferta;
use Cupon\CiudadBundle\Entity\Ciudad;
use Cupon\TiendaBundle\Entity\Tienda;
========
use AppBundle\Entity\Oferta;
use AppBundle\Entity\Ciudad;
use AppBundle\Entity\Tienda;
>>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Tests/Entity/OfertaTest.php

/**
 * Test unitario para asegurar que la validación de la entity offer
 * funciona correctamente
 */
class OfertaTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    protected function setUp()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    public function testValidarSlug()
    {
        $offer = new offer();

        $offer->setNombre('offer de prueba');
        $slug = $offer->getSlug();

        $this->assertEquals('offer-de-prueba', $slug, 'El slug se asigna automáticamente a partir del name');
    }

    public function testValidarDescripcion()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'La description no puede dejarse en blanco');

        $error = $listaErrores[0];
        $this->assertEquals('This value should not be blank.', $error->getMessage());
        $this->assertEquals('descripcion', $error->getPropertyPath());

        $offer->setDescripcion('description de prueba');

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'La description debe tener al menos 30 caracteres');

        $error = $listaErrores[0];
        $this->assertRegExp("/This value is too short/", $error->getMessage());
        $this->assertEquals('descripcion', $error->getPropertyPath());
    }

    public function testValidarFechas()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');

        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('yesterday'));

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'La date de expiración debe ser posterior a la date de publicación');

        $error = $listaErrores[0];
        $this->assertEquals('La date de expiración debe ser posterior a la date de publicación', $error->getMessage());
        $this->assertEquals('fechaValida', $error->getPropertyPath());
    }

    public function testValidarUmbral()
    {
        $offer = new offer();
        $offer->setNombre('offer de prueba');
        $offer->setDescripcion('description de prueba - description de prueba - description de prueba');
        $offer->setFechaPublicacion(new \DateTime('today'));
        $offer->setFechaExpiracion(new \DateTime('tomorrow'));

        $offer->setUmbral(3.5);

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'El umbral debe ser un number entero');

        $error = $listaErrores[0];
        $this->assertRegExp("/This value should be of type/", $error->getMessage());
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

        $offer->setPrecio(-10);

        $listaErrores = $this->validator->validate($offer);
        $this->assertGreaterThan(0, $listaErrores->count(), 'El price no puede ser un number negativo');

        $error = $listaErrores[0];
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

        $offer->setTienda($this->getTienda($city));
        $oferta_ciudad = $offer->getCiudad()->getNombre();
        $oferta_tienda_ciudad = $offer->getTienda()->getCiudad()->getNombre();

        $this->assertEquals($oferta_ciudad, $oferta_tienda_ciudad, 'La store asociada a la offer es de la misma city en la que se vende la offer');
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

>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
}
