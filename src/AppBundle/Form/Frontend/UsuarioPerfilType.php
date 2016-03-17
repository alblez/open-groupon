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
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('default'),
        ));
    }
}
