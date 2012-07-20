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
 * form para crear y manipular entidades de type offer.
 * Como se utiliza en el backend, el form incluye todas las propiedades
 * de la entity.
 */
class OfertaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('descripcion')
            ->add('condiciones')
            ->add('photo')
            ->add('price', 'money')
            ->add('discount', 'money')
            ->add('fecha_publicacion')
            ->add('fecha_expiracion')
            ->add('compras', 'integer')
            ->add('umbral', 'integer', array('label' => 'Compras necesarias'))
            ->add('revisada', null, array('required' => false))
            ->add('city')
            ->add('store')
        ;
    }

    public function getName()
    {
        return 'cupon_backendbundle_ofertatype';
    }
}
