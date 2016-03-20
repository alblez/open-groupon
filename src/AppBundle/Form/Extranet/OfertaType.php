<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Form\Extranet;

use AppBundle\Listener\OfertaTypeListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
<<<<<<< HEAD

        // El form es diferente según se utilice en la acción 'new' o en la acción 'edit'
        // Para determinar en qué acción estamos, se checks si el atributo `id` del objeto
        // es null, en cuyo caso estamos en la acción 'new'
        //
        // La acción `new` muestra un checkbox que no corresponde a ninguna propiedad de la entity
        // del modelo. Se añade dinámicamente y se indica que no es parte del modelo (con la propiedad
        // `property_path`).
        if (null == $options['data']->getId()) {
            $builder->add('acepto', 'checkbox', array('mapped' => false, 'required' => false));

            // registrar el listener que validará el campo 'acepto' añadido anteriormente
            $listener = new OfertaTypeListener();
            $builder->addEventListener(FormEvents::PRE_SUBMIT, array($listener, 'preSubmit'));
        }
||||||| parent of f8cf698 (Mejorada la forma en la que se implementa el checkbox de "Acepto las Condiciones")

        // El form es diferente según se utilice en la acción 'new' o en la acción 'edit'
        // Para determinar en qué acción estamos, se checks si el atributo `id` del objeto
        // es null, en cuyo caso estamos en la acción 'new'
        //
        // La acción `new` muestra un checkbox que no corresponde a ninguna propiedad de la entity
        // del modelo. Se añade dinámicamente y se indica que no es parte del modelo (con la propiedad
        // `property_path`).
        if (null == $options['data']->getId()) {
            $builder->add('acepto', 'checkbox', array('mapped' => false, 'required' => false));

            // registrar el listener que validará el campo 'acepto' añadido anteriormente
            $listener = new OfertaTypeListener();
            $builder->addEventListener(FormEvents::PRE_SUBMIT, array($listener, 'preSubmit'));
        }
=======
>>>>>>> f8cf698 (Mejorada la forma en la que se implementa el checkbox de "Acepto las Condiciones")
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\offer',
        ));
    }

    public function getBlockPrefix()
    {
        return 'oferta_tienda';
    }
}
