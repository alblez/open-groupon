<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Entity;

<<<<<<< HEAD
use AppBundle\Util\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadRepository")
 */
class city
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
     * @ORM\OneToMany(targetEntity="user", mappedBy="city")
     */
    private $usuarios;

    public function __toString()
    {
        return $this->getNombre();
    }

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
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
        $this->slug = Slugger::getSlug($name);
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
     * @return ArrayCollection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param user $user
     */
    public function addUsuario(user $user)
    {
        $this->usuarios->add($user);
        $user->setCiudad($this);
    }

    /**
     * @param user $user
     */
    public function removeUsuario(user $user)
    {
        $this->usuarios->removeElement($user);
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
=======
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Util;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadRepository")
 */
class city
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
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
    }
}
