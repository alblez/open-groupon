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
use Cupon\CiudadBundle\Entity\city;
use Cupon\BackendBundle\Form\CiudadType;

/**
 * city controller.
 *
 */
class CiudadController extends Controller
{
    /**
     * Lists all city entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CiudadBundle:city')->findAll();

        return $this->render('BackendBundle:city:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a city entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiudadBundle:city')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la city solicitada');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:city:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new city entity.
     *
     */
    public function newAction()
    {
        $entity = new city();
        $form   = $this->createForm(new CiudadType(), $entity);

        return $this->render('BackendBundle:city:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new city entity.
     *
     */
    public function createAction()
    {
        $entity  = new city();
        $request = $this->getRequest();
        $form    = $this->createForm(new CiudadType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_ciudad_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:city:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing city entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiudadBundle:city')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la city solicitada');
        }

        $editForm = $this->createForm(new CiudadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:city:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing city entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiudadBundle:city')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la city solicitada');
        }

        $editForm   = $this->createForm(new CiudadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_ciudad_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:city:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a city entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CiudadBundle:city')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado la city solicitada');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_ciudad'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
