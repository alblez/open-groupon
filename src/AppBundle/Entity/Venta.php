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

/**
 * @ORM\Entity
 */
class sale
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\offer")
     */
    protected $offer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\user")
     */
    protected $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $date
     */
    public function setFecha($date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->date;
    }

    /**
     * @param offer $offer
     */
    public function setOferta(offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * @return offer
     */
    public function getOferta()
    {
        return $this->offer;
    }

    /**
     * @param user $user
     */
    public function setUsuario(user $user)
    {
        $this->user = $user;
    }

    /**
     * @return user
     */
    public function getUsuario()
    {
        return $this->user;
    }
}
