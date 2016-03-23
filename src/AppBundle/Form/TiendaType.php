<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('name', null, array('attr' => array('class' => 'largo')))
            ->add('login', null, array('label' => 'name de user', 'attr' => array('readonly' => true)))
            ->add('passwordEnClaro', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType', array(
                'type' => 'Symfony\Component\Form\Extension\Core\Type\PasswordType',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options' => array('label' => 'password'),
                'second_options' => array('label' => 'Repite password'),
                'required' => false,
            ))
            ->add('descripcion', null, array('label' => 'description'))
            ->add('direccion')
            ->add('city')
            ->add('guardar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Guardar cambios',
                'attr' => array('class' => 'boton'),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\store',
        ));
    }

    public function getBlockPrefix()
    {
        return 'store';
    }
}
