<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\Form\Extranet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('photo', 'file', array('required' => false))
            ->add('price', 'money')
            ->add('discount', 'money')
            ->add('umbral')
        ;

        // El form es diferente según se utilice en la acción 'new' o en la acción 'edit'
        // Para determinar en qué acción estamos, se checks si el atributo `id` del objeto
        // es null, en cuyo caso estamos en la acción 'new'
        //
        // La acción `new` muestra un checkbox que no corresponde a ninguna propiedad de la entity
        // del modelo. Se añade dinámicamente y se indica que no es parte del modelo (con la propiedad
        // `property_path`).
        //
        // También se añade dinámicamente un validator para comprobar que el checkbox añadido ha sido
        // activado y para mostrar un message de error en caso contrario.
        if (null == $options['data']->getId()) {
            $builder->add('acepto', 'checkbox', array('mapped' => false));

            $builder->addValidator(new CallbackValidator(function(FormInterface $form) {
                if ($form["acepto"]->getData() == false) {
                    $form->addError(new FormError('Debes aceptar las condiciones indicadas antes de poder añadir una nueva offer'));
                }
            }));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cupon\OfertaBundle\Entity\offer',
        ));
    }

    public function getName()
    {
        return 'oferta_tienda';
    }
}
