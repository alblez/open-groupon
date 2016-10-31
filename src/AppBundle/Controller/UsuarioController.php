<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\user;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/user")
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/login", name="usuario_login")
     *
     * Muestra el form de login
     *
     * @return Response
     */
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('user/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/login_check", name="usuario_login_check")
     */
    public function loginCheckAction()
    {
        // el "login check" lo hace Symfony automáticamente
    }

    /**
     * @Route("/logout", name="usuario_logout")
     */
    public function logoutAction()
    {
        // el logout lo hace Symfony automáticamente
    }

    /**
     * @Cache(maxage="30")
     *
     * Muestra la caja de login que se incluye en el lateral de la mayoría de páginas del sitio web.
     * Esta caja se transforma en información y enlaces cuando el user se loguea en la application.
     * La response se marca como privada para que no se añada a la cache pública. El trozo de template
     * que llama a esta function se sirve a través de ESI.
     *
     * @return Response
     */
    public function cajaLoginAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('user/_caja_login.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/record", name="usuario_registro")
     *
     * Muestra el form para que se registren los nuevos usuarios. Además
     * se encarga de procesar la información y de guardar la información en la base de datos.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function registroAction(Request $request)
    {
        $user = new user();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $user, array(
            'accion' => 'crear_usuario',
            'validation_groups' => array('default', 'record'),
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('app.manager.usuario_manager')->guardar($user);
            $this->get('app.manager.usuario_manager')->loguear($user);

            $this->addFlash('info', '¡Enhorabuena! Te has registrado correctamente en Cupon');

            return $this->redirectToRoute('portada', array('city' => $user->getCiudad()->getSlug()));
        }

        return $this->render('user/record.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/perfil", name="usuario_perfil")
     *
     * Muestra el form con toda la información del perfil del user logueado.
     * También permite modificar la información y saves los cambios en la base de datos.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function perfilAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('app.manager.usuario_manager')->guardar($user);
            $this->addFlash('info', 'Los datos de tu perfil se han actualizado correctamente');

            return $this->redirectToRoute('usuario_perfil');
        }

        return $this->render('user/perfil.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/compras", name="usuario_compras")
     *
     * Muestra todas las compras del user logueado.
     *
     * @return Response
     */
    public function comprasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $cercanas = $em->getRepository('AppBundle:city')->findCercanas(
            $user->getCiudad()->getId()
        );

        $compras = $em->getRepository('AppBundle:user')->findTodasLasCompras($user->getId());

        return $this->render('user/compras.html.twig', array(
            'compras' => $compras,
            'cercanas' => $cercanas,
        ));
    }

    /**
     * @Route("/{city}/ofertas/{slug}/comprar", name="comprar")
     * @Security("is_granted('ROLE_USUARIO')")
     *
     * Registra una nueva purchase de la offer indicada por parte del user logueado.
     *
     * @param Request $request
     * @param string  $city  El slug de la city a la que pertenece la offer
     * @param string  $slug    El slug de la offer
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function comprarAction(Request $request, $city, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $city = $em->getRepository('AppBundle:city')->findOneBySlug($city);
        if (!$city) {
            throw $this->createNotFoundException('La city indicada no está disponible');
        }

        $offer = $em->getRepository('AppBundle:offer')->findOneBy(array('city' => $city->getId(), 'slug' => $slug));
        if (!$offer) {
            throw $this->createNotFoundException('La offer indicada no está disponible');
        }

        // Un mismo user no puede comprar dos veces la misma offer
        $sale = $em->getRepository('AppBundle:sale')->findOneBy(array(
            'offer' => $offer->getId(),
            'user' => $user->getId(),
        ));

        if (null !== $sale) {
            $this->addFlash('error', sprintf('No puedes volver a comprar esta offer (la compraste el %s)', $sale->getFecha()->format('d/m/Y')));

            return $this->redirect($request->headers->get('Referer', $this->generateUrl('portada')));
        }

        $this->get('app.manager.oferta_manager')->comprar($offer, $user);

        return $this->render('user/comprar.html.twig', array(
            'offer' => $offer,
            'user' => $user,
        ));
    }
}
