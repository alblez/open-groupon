<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
<<<<<<< HEAD
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Listener;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;

/**
 * Este listener se emplea para añadir un validator propio que compruebe los campos
 * del form que no se corresponden con ninguna propiedad de la entity.
 */
class OfertaTypeListener
{
    /**
     * Valida que el user ha activado el checkbox para aceptar las condiciones de uso.
     *
     * @param \Symfony\Component\Form\FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();

        if (false == $form->get('acepto')->getData()) {
            $form->get('acepto')->addError(new FormError(
                'Debes aceptar las condiciones indicadas antes de poder añadir una nueva offer'
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
=======
 * Este archivo pertenece a la aplicación de prueba Cupon.
 * El código fuente de la aplicación incluye un archivo llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Listener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

/**
 * Este listener se emplea para añadir un validador propio que compruebe los campos
 * del formulario que no se corresponden con ninguna propiedad de la entidad.
 */
class OfertaTypeListener
{
    /**
     * Valida que el usuario ha activado el checkbox para aceptar las condiciones de uso.
     *
     * @param \Symfony\Component\Form\FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $formulario = $event->getForm();

        if (false == $formulario->get('acepto')->getData()) {
            $formulario->get('acepto')->addError(new FormError(
                'Debes aceptar las condiciones indicadas antes de poder añadir una nueva oferta'
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
            ));
        }
    }
}
