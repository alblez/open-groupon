<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * form para crear y manipular entidades de type user.
 * Como se utiliza en el backend, el form incluye todas las propiedades
 * de la entity.
 */
class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('apellidos')
            ->add('email')
            ->add('password')
            ->add('salt')
            ->add('direccion')
            ->add('permite_email')
            ->add('fecha_alta')
            ->add('fecha_nacimiento')
            ->add('dni')
            ->add('numero_tarjeta')
            ->add('city')
        ;
    }

    public function getName()
    {
        return 'cupon_backendbundle_usuariotype';
    }
}
