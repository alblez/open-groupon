<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Cupon\UsuarioBundle\Entity\user;
use AppBundle\Form\Backend\UsuarioType;

/**
 * user controller.
 *
 */
class UsuarioController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->get('ideup.simple_paginator');

        $slug = $this->container->get('request_stack')->getCurrentRequest()->getSession()->get('city');

        $entities  = $paginador->paginate(
            $em->getRepository('CiudadBundle:city')->queryTodosLosUsuarios($slug)
        )->getResult();

        return $this->render('BackendBundle:user:index.html.twig', array(
            'entities'  => $entities,
            'paginador' => $paginador
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuarioBundle:user')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el user solicitado');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:user:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new user entity.
     *
     */
    public function newAction()
    {
        $entity = new user();
        $form   = $this->createForm(new UsuarioType(), $entity);

        return $this->render('BackendBundle:user:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function createAction()
    {
        $entity  = new user();
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $form    = $this->createForm(new UsuarioType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_usuario_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:user:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuarioBundle:user')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el user solicitado');
        }

        $editForm = $this->createForm(new UsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:user:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing user entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuarioBundle:user')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el user solicitado');
        }

        $editForm   = $this->createForm(new UsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_usuario_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:user:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UsuarioBundle:user')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado el user solicitado');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_usuario'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
