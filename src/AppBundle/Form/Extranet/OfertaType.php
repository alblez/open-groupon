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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

/**
 * form para crear y manipular entidades de type offer.
 * Como se utiliza en la extranet, algunas propiedades de la entity
 * no se incluyen en el form.
 */
class OfertaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('descripcion')
            ->add('condiciones')
            ->add('photo', 'Symfony\Component\Form\Extension\Core\Type\FileType', array('required' => false))
            ->add('price', 'Symfony\Component\Form\Extension\Core\Type\MoneyType')
            ->add('discount', 'Symfony\Component\Form\Extension\Core\Type\MoneyType')
            ->add('umbral')
            ->add('guardar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Guardar cambios',
                'attr' => array('class' => 'boton'),
            ))
        ;

        if (true === $options['mostrar_condiciones']) {
            // Cuando se creates una offer, se muestra un checkbox para aceptar las
            // condiciones de uso
            $builder->add('acepto', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array(
                'mapped' => false,
                'constraints' => new IsTrue(array(
                    'message' => 'Debes aceptar las condiciones indicadas antes de poder añadir una nueva offer',
                )),
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\offer',
            'mostrar_condiciones' => false,
        ));
    }

    public function getBlockPrefix()
    {
        return 'oferta_tienda';
    }
}
