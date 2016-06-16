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
use Cupon\TiendaBundle\Entity\store;
use AppBundle\Form\Backend\TiendaType;

/**
 * store controller.
 *
 */
class TiendaController extends Controller
{
    /**
     * Lists all store entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $slug = $this->container->get('request_stack')->getCurrentRequest()->getSession()->get('city');
        $entities = $em->getRepository('CiudadBundle:city')->findTodasLasTiendas($slug);

        return $this->render('BackendBundle:store:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a store entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TiendaBundle:store')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la store solicitada');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:store:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new store entity.
     *
     */
    public function newAction()
    {
        $entity = new store();
        $form   = $this->createForm(new TiendaType(), $entity);

        return $this->render('BackendBundle:store:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new store entity.
     *
     */
    public function createAction()
    {
        $entity  = new store();
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $form    = $this->createForm(new TiendaType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_tienda_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:store:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing store entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TiendaBundle:store')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la store solicitada');
        }

        $editForm = $this->createForm(new TiendaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:store:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing store entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TiendaBundle:store')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la store solicitada');
        }

        $editForm   = $this->createForm(new TiendaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_tienda_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:store:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a store entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TiendaBundle:store')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado la store solicitada');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_tienda'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
