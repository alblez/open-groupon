<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cupon\OfertaBundle\Entity\offer;
use Cupon\BackendBundle\Form\OfertaType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;

/**
 * offer controller.
 *
 */
class OfertaController extends Controller
{
    /**
     * Lists all offer entities.
     *
     */
    public function indexAction()
    {
        // Si el user no ha seleccionado ninguna city, seleccionar
        // la city por defecto
        $sesion = $this->getRequest()->getSession();
        if (null == $slug = $sesion->get('city')) {
            $slug = $this->container->getParameter('cupon.ciudad_por_defecto');
            $sesion->set('city', $slug);
        }

        $em = $this->getDoctrine()->getManager();
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(19);

        $entities  = $paginador->paginate(
            $em->getRepository('CiudadBundle:city')->queryTodasLasOfertas($slug)
        )->getResult();

        return $this->render('BackendBundle:offer:index.html.twig', array(
            'entities'  => $entities,
            'paginador' => $paginador
        ));
    }

    /**
     * Finds and displays a offer entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OfertaBundle:offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la offer solicitada');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:offer:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new offer entity.
     *
     */
    public function newAction()
    {
        $entity = new offer();

        // Rellenar con valores adecuados algunas propiedades
        $em = $this->getDoctrine()->getManager();

        $city = $em->getRepository('CiudadBundle:city')->findOneBySlug(
            $this->getRequest()->getSession()->get('city')
        );

        $entity->setCiudad($city);
        $entity->setCompras(0);
        $entity->setUmbral(0);
        $entity->setFechaPublicacion(new \DateTime('now'));
        $entity->setFechaExpiracion(new \DateTime('tomorrow'));

        $form = $this->createForm(new OfertaType(), $entity);

        return $this->render('BackendBundle:offer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new offer entity.
     *
     */
    public function createAction()
    {
        $entity  = new offer();
        $request = $this->getRequest();
        $form    = $this->createForm(new OfertaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            // Copiar la foto subida y guardar la ruta
            $entity->subirFoto($this->container->getParameter('cupon.directorio.imagenes'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_oferta_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:offer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OfertaBundle:offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la offer solicitada');
        }

        // el formulario necesita un objeto de tipo File, no la ruta de la foto
        $entity->setFoto(new File($entity->getFoto(), false));

        $editForm = $this->createForm(new OfertaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:offer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing offer entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OfertaBundle:offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la offer solicitada');
        }

        $fotoOriginal = $entity->getFoto();
        $entity->setFoto(new File($fotoOriginal, false));

        $editForm   = $this->createForm(new OfertaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            if (null == $entity->getFoto()) {
                    // el usuario no ha modificado la foto original
                    $entity->setFoto($fotoOriginal);
            } else {
                // el usuario ha modificado la foto: copiar la foto subida y
                // guardar la nueva ruta
                $entity->subirFoto($this->container->getParameter('cupon.directorio.imagenes'));

                // borrar la foto anterior
                if (!empty($fotoOriginal)) {
                    $fs = new Filesystem();
                    $fs->remove($this->container->getParameter('cupon.directorio.imagenes').$fotoOriginal);
                }
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_oferta_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:offer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a offer entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OfertaBundle:offer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado la offer solicitada');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_oferta'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
