<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Form\Extranet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * form para crear y manipular entidades de type store.
 * Como se utiliza en la extranet, algunas propiedades de la entity
 * no se incluyen en el form.
 */
class TiendaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('login', 'text', array('read_only' => true))

            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options'   => array('label' => 'password'),
                'second_options'  => array('label' => 'Repite password'),
                'required'        => false
            ))

            ->add('descripcion')
            ->add('direccion')
            ->add('city')

            ->add('guardar', 'submit', array(
                'label' => 'Guardar cambios',
                'attr'  => array('class' => 'boton')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
<<<<<<< HEAD:src/Cupon/TiendaBundle/Form/Extranet/TiendaType.php
            'data_class' => 'Cupon\TiendaBundle\Entity\store',
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/TiendaBundle/Form/Extranet/TiendaType.php
            'data_class' => 'Cupon\TiendaBundle\Entity\Tienda',
=======
            'data_class' => 'AppBundle\Entity\Tienda',
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Form/Extranet/TiendaType.php
        ));
    }

    public function getName()
    {
        return 'cupon_tiendabundle_tiendatype';
    }
}
