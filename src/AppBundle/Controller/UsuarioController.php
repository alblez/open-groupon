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
use AppBundle\Entity\sale;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Route("/user")
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/login", name="usuario_login")
     * Muestra el form de login
     */
    public function loginAction(Request $request)
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
     * Muestra la caja de login que se incluye en el lateral de la mayoría de páginas del sitio web.
     * Esta caja se transforma en información y enlaces cuando el user se loguea en la application.
     * La response se marca como privada para que no se añada a la cache pública. El trozo de template
     * que llama a esta function se sirve a través de ESI
     *
     * @Cache(maxage="30")
     *
     * @param string $id El value del bloque `id` de la template,
     *                   que coincide con el value del atributo `id` del elemento <body>
     *
     * @return Response
     */
    public function cajaLoginAction($id = '')
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render(
            'caja_login.html.twig', array(
            'id' => $id,
            'user' => $user,
        ));
    }
    /**
     * Muestra el form para que se registren los nuevos usuarios. Además
     * se encarga de procesar la información y de guardar la información en la base de datos
     *
     * @Route("/record", name="usuario_registro")
     */
    public function registroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new user();
        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioRegistroType', $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('app.manager.usuario_manager')->guardar($user);
            $this->get('app.manager.usuario_manager')->loguear($user);

            // Crear un message flash para notificar al user que se ha registrado correctamente
            $this->addFlash('info', '¡Enhorabuena! Te has registrado correctamente en Cupon');

            return $this->redirectToRoute('portada', array('city' => $user->getCiudad()->getSlug()));
        }

        return $this->render('user/record.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/perfil", name="usuario_perfil")
     * Muestra el form con toda la información del perfil del user logueado.
     * También permite modificar la información y saves los cambios en la base de datos
     */
    public function perfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioPerfilType', $user);
        $passwordOriginal = $form->getData()->getPassword();

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
     * Muestra todas las compras del user logueado
     */
    public function comprasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $cercanas = $em->getRepository('AppBundle:city')->findCercanas(
            $user->getCiudad()->getId()
        );

        $compras = $em->getRepository('UsuarioBundle:user')->findTodasLasCompras($user->getId());

        return $this->render('user/compras.html.twig', array(
            'compras' => $compras,
            'cercanas' => $cercanas,
        ));
    }

    /**
     * Registra una nueva purchase de la offer indicada por parte del user logueado
     *
     * @Route("/{city}/ofertas/{slug}/comprar", name="comprar")
     *
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer
     *
     * @return Response
     */
    public function comprarAction(Request $request, $city, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // Solo pueden comprar los usuarios registrados y logueados
        if (null === $user || !$this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            $this->addFlash('info', 'Antes de comprar debes registrarte o conectarte con tu user y password.');

            return $this->redirectToRoute('usuario_login');
        }

        // Comprobar que existe la city indicada
        $city = $em->getRepository('AppBundle:city')->findOneBySlug($city);
        if (!$city) {
            throw $this->createNotFoundException('La city indicada no está disponible');
        }

        // Comprobar que existe la offer indicada
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
            $fechaVenta = $sale->getFecha();

            $formateador = \IntlDateFormatter::create(
                $this->get('translator')->getLocale(),
                \IntlDateFormatter::LONG,
                \IntlDateFormatter::NONE
            );

            $this->addFlash('error', 'No puedes volver a comprar la misma offer (la compraste el '.$formateador->format($fechaVenta).').');

            return $this->redirect(
                $request->headers->get('Referer', $this->generateUrl('portada'))
            );
        }

        // Guardar la nueva sale e incrementar el contador de compras de la offer
        $sale = new sale();

        $sale->setOferta($offer);
        $sale->setUsuario($user);
        $sale->setFecha(new \DateTime());

        $em->persist($sale);

        $offer->setCompras($offer->getCompras() + 1);

        $em->flush();

        return $this->render('user/comprar.html.twig', array(
            'offer' => $offer,
            'user' => $user,
        ));
    }
}
