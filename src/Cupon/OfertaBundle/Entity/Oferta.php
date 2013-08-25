<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cupon\OfertaBundle\Util\Util;

/**
 * @ORM\Entity(repositoryClass="Cupon\OfertaBundle\Entity\OfertaRepository")
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
    protected $fecha_publicacion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Assert\DateTime
     */
    protected $fecha_expiracion;

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
     * @ORM\ManyToOne(targetEntity="Cupon\CiudadBundle\Entity\city")
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="Cupon\TiendaBundle\Entity\store")
     */
    protected $store;

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * @Assert\True(message = "La date de expiración debe ser posterior a la date de publicación")
     */
    public function isFechaValida()
    {
        if ($this->fecha_publicacion == null || $this->fecha_expiracion == null) {
            return true;
        }

        return $this->fecha_expiracion > $this->fecha_publicacion;
    }

    /**
     * Sube la photo de la offer copiándola en el directorio que se indica y
     * guardando en la entity la ruta hasta la photo
     *
     * @param string $directorioDestino Ruta completa del directorio al que se sube la photo
     */
    public function subirFoto($directorioDestino)
    {
        if (null === $this->getFoto()) {
            return;
        }

        $nombreArchivoFoto = uniqid('cupon-').'-1.'.$this->getFoto()->guessExtension();

        $this->getFoto()->move($directorioDestino, $nombreArchivoFoto);

        $this->setRutaFoto($nombreArchivoFoto);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setNombre($name)
    {
        $this->name = $name;
        $this->slug = Util::getSlug($name);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set descripcion
     *
     * @param text $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return text
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set condiciones
     *
     * @param text $condiciones
     */
    public function setCondiciones($condiciones)
    {
        $this->condiciones = $condiciones;
    }

    /**
     * Get condiciones
     *
     * @return text
     */
    public function getCondiciones()
    {
        return $this->condiciones;
    }

    /**
     * Set rutaFoto
     *
     * @param string $photo
     */
    public function setRutaFoto($rutaFoto)
    {
        $this->rutaFoto = $rutaFoto;
    }

    /**
     * Get rutaFoto
     *
     * @return string
     */
    public function getRutaFoto()
    {
        return $this->rutaFoto;
    }

    /**
     * Set photo.
     *
     * @param UploadedFile $photo
     */
    public function setFoto(UploadedFile $photo = null)
    {
        $this->photo = $photo;
    }

    /**
     * Get photo.
     *
     * @return UploadedFile
     */
    public function getFoto()
    {
        return $this->photo;
    }

    /**
     * Set price
     *
     * @param decimal $price
     */
    public function setPrecio($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return decimal
     */
    public function getPrecio()
    {
        return $this->price;
    }

    /**
     * Set discount
     *
     * @param decimal $discount
     */
    public function setDescuento($discount)
    {
        $this->discount = $discount;
    }

    /**
     * Get discount
     *
     * @return decimal
     */
    public function getDescuento()
    {
        return $this->discount;
    }

    /**
     * Set fecha_publicacion
     *
     * @param datetime $fechaPublicacion
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fecha_publicacion = $fechaPublicacion;
    }

    /**
     * Get fecha_publicacion
     *
     * @return datetime
     */
    public function getFechaPublicacion()
    {
        return $this->fecha_publicacion;
    }

    /**
     * Set fecha_expiracion
     *
     * @param datetime $fechaExpiracion
     */
    public function setFechaExpiracion($fechaExpiracion)
    {
        $this->fecha_expiracion = $fechaExpiracion;
    }

    /**
     * Get fecha_expiracion
     *
     * @return datetime
     */
    public function getFechaExpiracion()
    {
        return $this->fecha_expiracion;
    }

    /**
     * Set compras
     *
     * @param integer $compras
     */
    public function setCompras($compras)
    {
        $this->compras = $compras;
    }

    /**
     * Get compras
     *
     * @return integer
     */
    public function getCompras()
    {
        return $this->compras;
    }

    /**
     * Set umbral
     *
     * @param integer $umbral
     */
    public function setUmbral($umbral)
    {
        $this->umbral = $umbral;
    }

    /**
     * Get umbral
     *
     * @return integer
     */
    public function getUmbral()
    {
        return $this->umbral;
    }

    /**
     * Set revisada
     *
     * @param boolean $revisada
     */
    public function setRevisada($revisada)
    {
        $this->revisada = $revisada;
    }

    /**
     * Get revisada
     *
     * @return boolean
     */
    public function getRevisada()
    {
        return $this->revisada;
    }

    /**
     * Set city
     *
     * @param Cupon\CiudadBundle\Entity\city $city
     */
    public function setCiudad(\Cupon\CiudadBundle\Entity\city $city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return Cupon\CiudadBundle\Entity\city
     */
    public function getCiudad()
    {
        return $this->city;
    }

    /**
     * Set store
     *
     * @param Cupon\TiendaBundle\Entity\store $store
     */
    public function setTienda(\Cupon\TiendaBundle\Entity\store $store)
    {
        $this->store = $store;
    }

    /**
     * Get store
     *
     * @return Cupon\TiendaBundle\Entity\store
     */
    public function getTienda()
    {
        return $this->store;
    }
}
