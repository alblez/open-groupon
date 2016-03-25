<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * form para crear entidades de type user cuando los usuarios se
 * registran en el sitio.
 * Como se utiliza en la parte pública del sitio, algunas propiedades de
 * la entity no se incluyen en el form.
 */
class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
<<<<<<< HEAD
            ->add('apellidos', null, array('attr' => array('class' => 'largo')))
            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'email electrónico',
                'attr' => array(
                    'class' => 'largo',
                    'placeholder' => 'user@servidor',
                ),
            ))
            ->add('passwordEnClaro', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType', array(
                'type' => 'Symfony\Component\Form\Extension\Core\Type\PasswordType',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options' => array('label' => 'password'),
                'second_options' => array('label' => 'Repite password'),
                'required' => false,
            ))
            ->add('direccion', null, array('label' => 'address postal', 'attr' => array('class' => 'mediana')))
            ->add('permiteEmail', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array('required' => false))
            ->add('fechaNacimiento', 'Symfony\Component\Form\Extension\Core\Type\BirthdayType', array(
                'label' => 'date de nacimiento',
                'years' => range(date('Y') - 18, date('Y') - 18 - 120),
            ))
            ->add('dni', null, array('label' => 'DNI', 'attr' => array('class' => 'corto')))
            ->add('numeroTarjeta', null, array('label' => 'number de tarjeta de crédito'))
            ->add('city', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\\Entity\\city',
                'placeholder' => 'Selecciona una city',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ))
        ;

        if ('crear_usuario' === $options['accion']) {
            $builder->add('registrarme', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Registrarme',
                'attr' => array('class' => 'boton'),
            ));
        } elseif ('modificar_perfil' === $options['accion']) {
            $builder->add('guardar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Guardar cambios',
                'attr' => array('class' => 'boton'),
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'accion' => 'modificar_perfil',
            'data_class' => 'AppBundle\Entity\user',
            'validation_groups' => array('default'),
        ));
    }

    public function getBlockPrefix()
    {
        return 'user';
||||||| parent of cd05d74 (Simplificado el formulario para registrar usuarios y editar perfiles de usuario)
=======
            ->add('apellidos')
            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'email electrónico',
                'attr' => array(
                    'placeholder' => 'user@servidor',
                ),
            ))
            ->add('passwordEnClaro', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType', array(
                'type' => 'Symfony\Component\Form\Extension\Core\Type\PasswordType',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options' => array('label' => 'password'),
                'second_options' => array('label' => 'Repite password'),
                'required' => false,
            ))
            ->add('direccion')
            ->add('permiteEmail', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array('required' => false))
            ->add(
                'fechaNacimiento', 'Symfony\Component\Form\Extension\Core\Type\BirthdayType', array(
                'years' => range(date('Y') - 18, date('Y') - 18 - 120),
            ))
            ->add('dni')
            ->add('numeroTarjeta', null, array('label' => 'Tarjeta de Crédito'))
            ->add('city', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\\Entity\\city',
                'placeholder' => 'Selecciona una city',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ))
        ;

        if ('crear_usuario' === $options['accion']) {
            $builder->add('registrarme', 'Symfony\Component\Form\Extension\Core\Type\SubmitType');
        } elseif ('modificar_perfil' === $options['accion']) {
            $builder->add('guardar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Guardar cambios',
                'attr' => array('class' => 'boton'),
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
<<<<<<<< HEAD:src/AppBundle/Form/Frontend/UsuarioRegistroType.php
            'data_class' => 'AppBundle\Entity\user',
            'validation_groups' => array('default', 'record'),
|||||||| parent of cd05d74 (Simplificado el formulario para registrar usuarios y editar perfiles de usuario):src/AppBundle/Form/Frontend/UsuarioRegistroType.php
            'data_class' => 'AppBundle\Entity\Usuario',
            'validation_groups' => array('default', 'registro'),
========
            'accion' => 'modificar_perfil',
            'data_class' => 'AppBundle\Entity\Usuario',
            'validation_groups' => array('default'),
>>>>>>>> cd05d74 (Simplificado el formulario para registrar usuarios y editar perfiles de usuario):src/AppBundle/Form/UsuarioType.php
        ));
    }

    public function getBlockPrefix()
    {
        return 'frontend_usuario';
>>>>>>> cd05d74 (Simplificado el formulario para registrar usuarios y editar perfiles de usuario)
    }
}
