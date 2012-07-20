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

/**
 * @ORM\Entity
 */
class sale
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Cupon\OfertaBundle\Entity\offer")
     */
    protected $offer;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Cupon\UsuarioBundle\Entity\user")
     */
    protected $user;

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setFecha($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime
     */
    public function getFecha()
    {
        return $this->date;
    }

    /**
     * Set offer
     *
     * @param Cupon\OfertaBundle\Entity\offer $offer
     */
    public function setOferta(\Cupon\OfertaBundle\Entity\offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Get offer
     *
     * @return Cupon\OfertaBundle\Entity\offer
     */
    public function getOferta()
    {
        return $this->offer;
    }

    /**
     * Set user
     *
     * @param Cupon\UsuarioBundle\Entity\user $user
     */
    public function setUsuario(\Cupon\UsuarioBundle\Entity\user $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Cupon\UsuarioBundle\Entity\user
     */
    public function getUsuario()
    {
        return $this->user;
    }
}
