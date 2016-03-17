<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Form\Frontend;

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
class UsuarioRegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('apellidos')
            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'email electrónico',
                'attr' => array(
                    'placeholder' => 'user@servidor',
                )
            ))

            ->add('password', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType', array(
                'type' => 'password',
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
            ->add(
                'numeroTarjeta', null, array(
                'label' => 'Tarjeta de Crédito',
                'attr' => array(
                    'pattern' => '^[0-9]{13,16}$',
                    'placeholder' => 'Entre 13 y 16 numeros',
                )
            ))

            ->add('city', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\\Entity\\city',
                'empty_value' => 'Selecciona una city',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ))

            ->add('registrarme', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\user',
            'validation_groups' => array('default', 'record'),
        ));
    }

    public function getBlockPrefix()
    {
        return 'frontend_usuario';
    }
}
