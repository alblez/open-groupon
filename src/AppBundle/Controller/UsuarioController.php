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

<<<<<<< HEAD
        $error = $request->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('user/login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
        $error = $request->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('user/login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
=======
        return $this->render('user/login.html.twig.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
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
<<<<<<< HEAD
     * @param string $id El value del bloque `id` de la template,
     *                   que coincide con el value del atributo `id` del elemento <body>
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
     * @param string $id El value del bloque `id` de la template,
     *                   que coincide con el value del atributo `id` del elemento <body>
=======
     * @Cache(maxage="30")
     *
     * @param string $id El value del bloque `id` de la template,
     *                   que coincide con el value del atributo `id` del elemento <body>
     *
     * @return Response
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
     */
    public function cajaLoginAction($id = '')
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

<<<<<<< HEAD
        return $this->render('user/cajaLogin.html.twig', array(
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
        return $this->render('user/cajaLogin.html.twig', array(
=======
        return $this->render('user/cajaLogin.html.twig.html.twig', array(
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
            'id' => $id,
            'user' => $user,
        ));
    }
    /**
<<<<<<< HEAD
     * @Route("/record", name="usuario_registro")
     * Muestra el form para que se registren los nuevos usuarios. Además
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
     * @Route("/record", name="usuario_registro")
     * Muestra el form para que se registren los nuevos usuarios. Además
=======
     * Muestra el form para que se registren los nuevos usuarios. Además
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
     * se encarga de procesar la información y de guardar la información en la base de datos
     *
     * @Route("/record", name="usuario_registro")
     */
    public function registroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<< HEAD
        $user = new user();
        $user->setPermiteEmail(true);

        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioRegistroType', $user);

        $form->handleRequest($request);
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
        $user = new user();
        $user->setPermiteEmail(true);

        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioRegistroType', $user);

        $form->handleRequest($request);
=======
        $user = new user();
        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioRegistroType', $user);
        $form->handleRequest($request);
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)

<<<<<<< HEAD
        if ($form->isValid()) {
            // Completar las propiedades que el user no rellena en el form
            $user->setSalt(md5(time()));

            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $passwordCodificado = $encoder->encodePassword(
                $user->getPassword(),
                $user->getSalt()
            );
            $user->setPassword($passwordCodificado);
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
        if ($form->isValid()) {
            // Completar las propiedades que el user no rellena en el form
            $user->setSalt(md5(time()));

            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $passwordCodificado = $encoder->encodePassword(
                $user->getPassword(),
                $user->getSalt()
            );
            $user->setPassword($passwordCodificado);
=======
        if ($form->isValid()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $passwordCodificado = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($passwordCodificado);
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)

            // Guardar el nuevo user en la base de datos
            $em->persist($user);
            $em->flush();

<<<<<<< HEAD
            // Crear un message flash para notificar al user que se ha registrado correctamente
            $this->get('session')->getFlashBag()->add('info',
                '¡Enhorabuena! Te has registrado correctamente en Cupon'
            );
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
            // Crear un message flash para notificar al user que se ha registrado correctamente
            $this->get('session')->getFlashBag()->add('info',
                '¡Enhorabuena! Te has registrado correctamente en Cupon'
            );
=======
            // Crear un message flash para notificar al user que se ha registrado correctamente
            $this->addFlash('info', '¡Enhorabuena! Te has registrado correctamente en Cupon');
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)

            // Loguear al user automáticamente
            $token = new UsernamePasswordToken($user, null, 'frontend', $user->getRoles());
            $this->container->get('security.token_storage')->setToken($token);

<<<<<<< HEAD
            return $this->redirect($this->generateUrl('portada', array(
                'city' => $user->getCiudad()->getSlug(),
            )));
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
            return $this->redirect($this->generateUrl('portada', array(
                'city' => $user->getCiudad()->getSlug(),
            )));
=======
            return $this->redirectToRoute('portada', array('city' => $user->getCiudad()->getSlug()));
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
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

<<<<<<< HEAD
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioPerfilType', $user);
        $form
            ->remove('registrarme')
            ->add('guardar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Guardar cambios',
                'attr' => array('class' => 'boton'),
            ))
        ;

        $passwordOriginal = $form->getData()->getPassword();
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioPerfilType', $user);
        $form
            ->remove('registrarme')
            ->add('guardar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Guardar cambios',
                'attr' => array('class' => 'boton'),
            ))
        ;

        $passwordOriginal = $form->getData()->getPassword();
=======
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('AppBundle\Form\Frontend\UsuarioPerfilType', $user);
        $passwordOriginal = $form->getData()->getPassword();
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)

        $form->handleRequest($request);

<<<<<<< HEAD
        if ($form->isValid()) {
            // Si el user no ha cambiado el password, su value es null después
            // de hacer el ->bindRequest(), por lo que hay que recuperar el value original

            if (null == $user->getPassword()) {
                $user->setPassword($passwordOriginal);
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
        if ($form->isValid()) {
            // Si el user no ha cambiado el password, su value es null después
            // de hacer el ->bindRequest(), por lo que hay que recuperar el value original

            if (null == $user->getPassword()) {
                $user->setPassword($passwordOriginal);
=======
        if ($form->isValid()) {
            // Si el user no ha cambiado el password, su value es null después
            // de hacer el ->bindRequest(), por lo que hay que recuperar el value original
            if (null === $user->getPassword()) {
                $user->setPassword($passwordOriginal);
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
            }
            // Si el user ha cambiado su password, hay que codificarlo antes de guardarlo
            else {
<<<<<<< HEAD
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $passwordCodificado = $encoder->encodePassword(
                    $user->getPassword(),
                    $user->getSalt()
                );
                $user->setPassword($passwordCodificado);
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $passwordCodificado = $encoder->encodePassword(
                    $user->getPassword(),
                    $user->getSalt()
                );
                $user->setPassword($passwordCodificado);
=======
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $passwordCodificado = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($passwordCodificado);
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
            }

            $em->persist($user);
            $em->flush();

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
<<<<<<< HEAD
     * @Route("/{city}/ofertas/{slug}/comprar", name="comprar")
     * Registra una nueva purchase de la offer indicada por parte del user logueado
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
     * @Route("/{city}/ofertas/{slug}/comprar", name="comprar")
     * Registra una nueva purchase de la offer indicada por parte del user logueado
=======
     * Registra una nueva purchase de la offer indicada por parte del user logueado
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
     *
<<<<<<< HEAD
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer
=======
     * @Route("/{city}/ofertas/{slug}/comprar", name="comprar")
     *
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer
     *
     * @return Response
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)
     */
    public function comprarAction(Request $request, $city, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // Solo pueden comprar los usuarios registrados y logueados
<<<<<<< HEAD
        if (null === $user || !$this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->getFlashBag()->add('info',
                'Antes de comprar debes registrarte o conectarte con tu user y password.'
            );
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
        if (null === $user || !$this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->getFlashBag()->add('info',
                'Antes de comprar debes registrarte o conectarte con tu user y password.'
            );
=======
        if (null === $user || !$this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            $this->addFlash('info', 'Antes de comprar debes registrarte o conectarte con tu user y password.');
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)

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

<<<<<<< HEAD
            $this->get('session')->getFlashBag()->add('error',
                'No puedes volver a comprar la misma offer (la compraste el '.$formateador->format($fechaVenta).').'
            );
||||||| parent of c25d0b1 (Actualizados todos los controladores para usar atajos)
            $this->get('session')->getFlashBag()->add('error',
                'No puedes volver a comprar la misma offer (la compraste el '.$formateador->format($fechaVenta).').'
            );
=======
            $this->addFlash('error', 'No puedes volver a comprar la misma offer (la compraste el '.$formateador->format($fechaVenta).').');
>>>>>>> c25d0b1 (Actualizados todos los controladores para usar atajos)

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
