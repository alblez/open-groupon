<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TiendaRepository")
 */
class store implements UserInterface
{
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
     * @ORM\Column(type="string", length=15)
     */
    protected $login;

    private $passwordEnClaro;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="text")
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="text")
     */
    protected $direccion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\city")
     */
    protected $city;

    public function __toString()
    {
        return $this->getNombre();
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
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $password
     */
    public function setPasswordEnClaro($password)
    {
        $this->passwordEnClaro = $password;
    }

    /**
     * @return string
     */
    public function getPasswordEnClaro()
    {
        return $this->passwordEnClaro;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
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
     * method requerido por la interfaz UserInterface.
     *
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_TIENDA');
    }

    /**
     * method requerido por la interfaz UserInterface.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getLogin();
    }

    /**
     * method requerido por la interfaz UserInterface.
     */
    public function eraseCredentials()
    {
        $this->passwordEnClaro = null;
    }

    /**
     * Este method es requerido por la interfaz UserInterface, pero esta clase
     * no necesita implementarlo porque se usa 'bcrypt' para codificar las contraseñas.
     */
    public function getSalt()
    {
        return;
    }
}
