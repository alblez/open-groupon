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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * form para crear y manipular entidades de type city.
 * Como se utiliza en el backend, el form incluye todas las propiedades
 * de la entity.
 */
class CiudadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('guardar', 'submit', array('attr' => array('class' => 'boton')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cupon\CiudadBundle\Entity\city',
        ));
    }

    public function getBlockPrefix()
    {
        return 'cupon_backendbundle_ciudadtype';
    }
}
