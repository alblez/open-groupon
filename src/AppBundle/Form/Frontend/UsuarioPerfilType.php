<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Form\Frontend;

use Symfony\Component\Form\FormBuilderInterface;
<<<<<<< HEAD
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * form para editar el perfil de los usuarios registrados.
 */
class UsuarioPerfilType extends UsuarioRegistroType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('registrarme')
            ->add('guardar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Guardar cambios',
                'attr' => array('class' => 'boton'),
            ))
        ;
    }

    /**
     * El form para editar el perfil utiliza una validación diferente a
     * la del form para darse de alta (escribir la password por
     * ejemplo no es required).
     */
    public function configureOptions(OptionsResolver $resolver)
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
=======
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\Frontend\UsuarioRegistroType;

/**
 * form para editar el perfil de los usuarios registrados.
 */
class UsuarioPerfilType extends UsuarioRegistroType
{
    /**
     * El form para editar el perfil utiliza una validación diferente a
     * la del form para darse de alta (escribir la password por
     * ejemplo no es required)
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('default'),
        ));
    }
}
