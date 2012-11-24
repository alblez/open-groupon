<?php

// Descomenta el code de esta clase si quieres probar SonataAdminBundle

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

// namespace Cupon\OfertaBundle\Admin;

// use Sonata\AdminBundle\Admin\Admin;
// use Sonata\AdminBundle\Form\FormMapper;
// use Sonata\AdminBundle\Datagrid\DatagridMapper;
// use Sonata\AdminBundle\Datagrid\ListMapper;

// /**
//  * Clase requerida por SonataAdminBundle para gestionar las entidades
//  * de type offer.
//  */
// class OfertaAdmin extends Admin
// {
//     /**
//      * Define los campos que se muestran en la page que lista las
//      * ofertas disponibles.
//      */
//     protected function configureListFields(ListMapper $mapper)
//     {
//         $mapper
//             ->add('revisada')
//             ->addIdentifier('name', null, array('label' => 'Título'))
//             ->add('store')
//             ->add('city')
//             ->add('price')
//             ->add('compras')
//         ;
//     }
// 
//     /**
//      * Define los filtros y campos de search disponibles para
//      * la sección de administración de ofertas.
//      */
//     protected function configureDatagridFilters(DatagridMapper $mapper)
//     {
//         $mapper
//             ->add('name')
//             ->add('descripcion')
//             ->add('city')
//         ;
//     }
// 
//     /**
//      * Define los campos que incluyen los formularios que muestran
//      * y permiten editar los datos de las ofertas.
//      */
//     protected function configureFormFields(FormMapper $mapper)
//     {
//         $mapper
//             ->with('Datos básicos')
//                 ->add('name')
//                 ->add('slug', null, array('required' => false))
//                 ->add('descripcion')
//                 ->add('condiciones')
//                 ->add('fecha_publicacion', 'datetime')
//                 ->add('fecha_expiracion', 'datetime')
//                 ->add('revisada')
//             ->end()
//             ->with('photo')
//                 ->add('photo')
//             ->end()
//             ->with('price y compras')
//                 ->add('price')
//                 ->add('discount')
//                 ->add('compras')
//                 ->add('umbral')
//             ->end()
//             ->with('store y city')
//                 ->add('store')
//                 ->add('city')
//             ->end()
//         ;
//     }
// }
