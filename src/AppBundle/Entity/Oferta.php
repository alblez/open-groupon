<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Entity;

use AppBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfertaRepository")
 * @Vich\Uploadable
 */
class offer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $slug;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 30)
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="text")
     */
    protected $condiciones;

    /**
     * @ORM\Column(type="string")
     */
    protected $rutaFoto;

    /**
     * @Assert\Image(maxSize = "500k")
     * @Vich\UploadableField(mapping="fotos_ofertas", fileNameProperty="rutaFoto")
     */
    protected $photo;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Assert\Range(min = 0)
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $discount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Assert\DateTime
     */
    protected $fechaPublicacion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Assert\DateTime
     */
    protected $fechaExpiracion;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
     */
    protected $fechaActualizacion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $compras;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\Type(type="integer")
     * @Assert\Range(min = 0)
     */
    protected $umbral;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Assert\Type(type="bool")
     */
    protected $revisada;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\city")
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\store")
     */
    protected $store;

    public function __toString()
    {
        return $this->getNombre();
    }

    public function __construct()
    {
        $this->compras = 0;
        $this->revisada = false;
        $this->fechaActualizacion = new \Datetime();
    }

    /**
     * Este method estático actúa como "constructor con name" y simplifica el
     * code de la application ya que rellena los campos de la offer que no
     * puede rellenar la store que ha creado la offer.
     *
     * @param store $store
     *
     * @return offer
     */
    public static function crearParaTienda(store $store)
    {
        $offer = new self();

        $offer->setTienda($store);
        $offer->setCiudad($store->getCiudad());

        return $offer;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setNombre($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->name;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $condiciones
     */
    public function setCondiciones($condiciones)
    {
        $this->condiciones = $condiciones;
    }

    /**
     * @return string
     */
    public function getCondiciones()
    {
        return $this->condiciones;
    }

    /**
     * @param string $rutaFoto
     */
    public function setRutaFoto($rutaFoto)
    {
        $this->rutaFoto = $rutaFoto;
    }

    /**
     * @return string
     */
    public function getRutaFoto()
    {
        return $this->rutaFoto;
    }

    /**
     * @param File $photo
     */
    public function setFoto(File $photo = null)
    {
        $this->photo = $photo;

        // para que el "listener" de Doctrine guarde bien los cambios, al menos
        // una propiedad debe cambiar su value (además de la propiedad de la photo)
        if (null !== $photo) {
            $this->fechaActualizacion = new \Datetime('now');
        }
    }

    /**
     * @return UploadedFile
     */
    public function getFoto()
    {
        return $this->photo;
    }

    /**
     * @param float $price
     */
    public function setPrecio($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrecio()
    {
        return $this->price;
    }

    /**
     * @param float $discount
     */
    public function setDescuento($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return float
     */
    public function getDescuento()
    {
        return $this->discount;
    }

    /**
     * @param \DateTime $fechaPublicacion
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fechaPublicacion = $fechaPublicacion;
    }

    /**
     * @return \DateTime
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }

    /**
     * @param \DateTime $fechaExpiracion
     */
    public function setFechaExpiracion($fechaExpiracion)
    {
        $this->fechaExpiracion = $fechaExpiracion;
    }

    /**
     * @return \DateTime
     */
    public function getFechaExpiracion()
    {
        return $this->fechaExpiracion;
    }

    /**
     * @param \DateTime $fechaActualizacion
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;
    }

    /**
     * @return \DateTime
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * @param int $compras
     */
    public function setCompras($compras)
    {
        $this->compras = $compras;
    }

    /**
     * @return int
     */
    public function getCompras()
    {
        return $this->compras;
    }

    /**
     * @param int $umbral
     */
    public function setUmbral($umbral)
    {
        $this->umbral = $umbral;
    }

    /**
     * @return int
     */
    public function getUmbral()
    {
        return $this->umbral;
    }

    /**
     * @param bool $revisada
     */
    public function setRevisada($revisada)
    {
        $this->revisada = $revisada;
    }

    /**
     * @return bool
     */
    public function getRevisada()
    {
        return $this->revisada;
    }

    /**
     * @param city $city
     */
    public function setCiudad(city $city)
    {
        $this->city = $city;
    }

    /**
     * @return city
     */
    public function getCiudad()
    {
        return $this->city;
    }

    /**
     * @param store $store
     */
    public function setTienda(store $store)
    {
        $this->store = $store;
    }

    /**
     * @return store
     */
    public function getTienda()
    {
        return $this->store;
    }

    /**
     * @Assert\IsTrue(message = "La date de expiración debe ser posterior a la date de publicación")
     */
    public function isFechaValida()
    {
        if (null === $this->fechaPublicacion || null === $this->fechaExpiracion) {
            return true;
        }

        return $this->fechaExpiracion > $this->fechaPublicacion;
    }
}
