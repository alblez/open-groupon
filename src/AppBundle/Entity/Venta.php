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
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Id
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
     * @ORM\ManyToOne(targetEntity="Cupon\OfertaBundle\Entity\offer")
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
     * @ORM\ManyToOne(targetEntity="Cupon\OfertaBundle\Entity\Oferta")
=======
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oferta")
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
     */
    protected $offer;

    /**
     * @ORM\Id
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
     * @ORM\ManyToOne(targetEntity="Cupon\UsuarioBundle\Entity\user")
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
     * @ORM\ManyToOne(targetEntity="Cupon\UsuarioBundle\Entity\Usuario")
=======
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
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
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
     * @param Cupon\OfertaBundle\Entity\offer $offer
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
     * @param Cupon\OfertaBundle\Entity\Oferta $oferta
=======
     * @param AppBundle\Entity\Oferta $oferta
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
     */
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
    public function setOferta(\Cupon\OfertaBundle\Entity\offer $offer)
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
    public function setOferta(\Cupon\OfertaBundle\Entity\Oferta $oferta)
=======
    public function setOferta(\AppBundle\Entity\Oferta $oferta)
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
    {
        $this->offer = $offer;
    }

    /**
     * Get offer
     *
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
     * @return Cupon\OfertaBundle\Entity\offer
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
     * @return Cupon\OfertaBundle\Entity\Oferta
=======
     * @return AppBundle\Entity\Oferta
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
     */
    public function getOferta()
    {
        return $this->offer;
    }

    /**
     * Set user
     *
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
     * @param Cupon\UsuarioBundle\Entity\user $user
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
     * @param Cupon\UsuarioBundle\Entity\Usuario $usuario
=======
     * @param AppBundle\Entity\Usuario $usuario
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
     */
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
    public function setUsuario(\Cupon\UsuarioBundle\Entity\user $user)
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
    public function setUsuario(\Cupon\UsuarioBundle\Entity\Usuario $usuario)
=======
    public function setUsuario(\AppBundle\Entity\Usuario $usuario)
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
<<<<<<< HEAD:src/Cupon/OfertaBundle/Entity/Venta.php
     * @return Cupon\UsuarioBundle\Entity\user
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/OfertaBundle/Entity/Venta.php
     * @return Cupon\UsuarioBundle\Entity\Usuario
=======
     * @return AppBundle\Entity\Usuario
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Entity/Venta.php
     */
    public function getUsuario()
    {
        return $this->user;
    }
}
