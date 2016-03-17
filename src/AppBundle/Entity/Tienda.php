<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Util;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TiendaRepository")
 */
class store implements UserInterface
{
    /**
     * method requerido por la interfaz UserInterface
     */
    public function eraseCredentials()
    {
    }

    /**
     * method requerido por la interfaz UserInterface
     */
    public function getRoles()
    {
        return array('ROLE_TIENDA');
    }

    /**
     * method requerido por la interfaz UserInterface
     */
    public function getUsername()
    {
        return $this->getLogin();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\Column(type="text")
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="text")
     */
    protected $direccion;

    /**
<<<<<<< HEAD:src/Cupon/TiendaBundle/Entity/Tienda.php
     * @ORM\ManyToOne(targetEntity="Cupon\CiudadBundle\Entity\city")
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Entity/Tienda.php
     * @ORM\ManyToOne(targetEntity="Cupon\CiudadBundle\Entity\Ciudad")
=======
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudad")
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Tienda.php
     */
    protected $city;

    public function __toString()
    {
        return $this->getNombre();
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
     * Set login
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
     * Set direccion
     *
     * @param text $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Get direccion
     *
     * @return text
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set city
     *
<<<<<<< HEAD:src/Cupon/TiendaBundle/Entity/Tienda.php
     * @param Cupon\CiudadBundle\Entity\city $city
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Entity/Tienda.php
     * @param Cupon\CiudadBundle\Entity\Ciudad $ciudad
=======
     * @param AppBundle\Entity\Ciudad $ciudad
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Tienda.php
     */
<<<<<<< HEAD:src/Cupon/TiendaBundle/Entity/Tienda.php
    public function setCiudad(\Cupon\CiudadBundle\Entity\city $city)
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Entity/Tienda.php
    public function setCiudad(\Cupon\CiudadBundle\Entity\Ciudad $ciudad)
=======
    public function setCiudad(\AppBundle\Entity\Ciudad $ciudad)
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Tienda.php
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
<<<<<<< HEAD:src/Cupon/TiendaBundle/Entity/Tienda.php
     * @return Cupon\CiudadBundle\Entity\city
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Entity/Tienda.php
     * @return Cupon\CiudadBundle\Entity\Ciudad
=======
     * @return AppBundle\Entity\Ciudad
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Tienda.php
     */
    public function getCiudad()
    {
        return $this->city;
    }
}
