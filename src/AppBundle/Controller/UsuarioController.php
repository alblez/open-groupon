<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
use Cupon\UsuarioBundle\Entity\user;
use Cupon\OfertaBundle\Entity\sale;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioPerfilType;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioRegistroType;
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
use Cupon\UsuarioBundle\Entity\Usuario;
use Cupon\OfertaBundle\Entity\Venta;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioPerfilType;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioRegistroType;
=======
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Venta;
use AppBundle\Form\Frontend\UsuarioPerfilType;
use AppBundle\Form\Frontend\UsuarioRegistroType;
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra el form de login
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra el formulario de login
=======
     * @Route("/login", name="usuario_login")
     * Muestra el formulario de login
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
     */
    public function loginAction(Request $peticion)
    {
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('usuario/login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
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
     * @Route("/login", name="usuario_login")
     * Muestra la caja de login que se incluye en el lateral de la mayoría de páginas del sitio web.
     * Esta caja se transforma en información y enlaces cuando el user se loguea en la application.
     * La response se marca como privada para que no se añada a la cache pública. El trozo de template
     * que llama a esta function se sirve a través de ESI
     *
     * @param string $id El value del bloque `id` de la template,
     *                   que coincide con el value del atributo `id` del elemento <body>
     */
    public function cajaLoginAction($id = '')
    {
        $user = $this->get('security.context')->getToken()->getUser();

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        $response = $this->render('UsuarioBundle:Default:cajaLogin.html.twig', array(
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        $respuesta = $this->render('UsuarioBundle:Default:cajaLogin.html.twig', array(
=======
        $respuesta = $this->render('usuario/cajaLogin.html.twig', array(
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
            'id'      => $id,
            'user' => $user
        ));

        $response->setMaxAge(30);

        return $response;
    }

    /**
<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra el form para que se registren los nuevos usuarios. Además
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra el formulario para que se registren los nuevos usuarios. Además
=======
     * @Route("/registro", name="usuario_registro")
     * Muestra el formulario para que se registren los nuevos usuarios. Además
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
     * se encarga de procesar la información y de guardar la información en la base de datos
     */
    public function registroAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new user();
        $user->setPermiteEmail(true);

        $form = $this->createForm(new UsuarioRegistroType(), $user);

        $form->handleRequest($peticion);

        if ($form->isValid()) {
            // Completar las propiedades que el user no rellena en el form
            $user->setSalt(md5(time()));

            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $passwordCodificado = $encoder->encodePassword(
                $user->getPassword(),
                $user->getSalt()
            );
            $user->setPassword($passwordCodificado);

            // Guardar el nuevo user en la base de datos
            $em->persist($user);
            $em->flush();

            // Crear un message flash para notificar al user que se ha registrado correctamente
            $this->get('session')->getFlashBag()->add('info',
                '¡Enhorabuena! Te has registrado correctamente en Cupon'
            );

            // Loguear al user automáticamente
            $token = new UsernamePasswordToken($user, null, 'frontend', $user->getRoles());
            $this->container->get('security.context')->setToken($token);

            return $this->redirect($this->generateUrl('portada', array(
                'city' => $user->getCiudad()->getSlug()
            )));
        }

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        return $this->render('UsuarioBundle:Default:record.html.twig', array(
            'form' => $form->createView()
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        return $this->render('UsuarioBundle:Default:registro.html.twig', array(
            'formulario' => $formulario->createView()
=======
        return $this->render('usuario/registro.html.twig', array(
            'formulario' => $formulario->createView()
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra el form con toda la información del perfil del user logueado.
     * También permite modificar la información y saves los cambios en la base de datos
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra el formulario con toda la información del perfil del usuario logueado.
     * También permite modificar la información y guarda los cambios en la base de datos
=======
     * @Route("/perfil", name="usuario_perfil")
     * Muestra el formulario con toda la información del perfil del usuario logueado.
     * También permite modificar la información y guarda los cambios en la base de datos
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
     */
    public function perfilAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new UsuarioPerfilType(), $user);
        $form
            ->remove('registrarme')
            ->add('guardar', 'submit', array(
                'label' => 'Guardar cambios',
                'attr'  => array('class' => 'boton')
            ))
        ;

        $passwordOriginal = $form->getData()->getPassword();

        $form->handleRequest($peticion);

        if ($form->isValid()) {
            // Si el user no ha cambiado el password, su value es null después
            // de hacer el ->bindRequest(), por lo que hay que recuperar el value original

            if (null == $user->getPassword()) {
                $user->setPassword($passwordOriginal);
            }
            // Si el user ha cambiado su password, hay que codificarlo antes de guardarlo
            else {
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $passwordCodificado = $encoder->encodePassword(
                    $user->getPassword(),
                    $user->getSalt()
                );
                $user->setPassword($passwordCodificado);
            }

            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info',
                'Los datos de tu perfil se han actualizado correctamente'
            );

            return $this->redirect($this->generateUrl('usuario_perfil'));
        }

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        return $this->render('UsuarioBundle:Default:perfil.html.twig', array(
            'user'    => $user,
            'form' => $form->createView()
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        return $this->render('UsuarioBundle:Default:perfil.html.twig', array(
            'usuario'    => $usuario,
            'formulario' => $formulario->createView()
=======
        return $this->render('usuario/perfil.html.twig', array(
            'usuario'    => $usuario,
            'formulario' => $formulario->createView()
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra todas las compras del user logueado
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Muestra todas las compras del usuario logueado
=======
     * @Route("/compras", name="usuario_compras")
     * Muestra todas las compras del usuario logueado
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
     */
    public function comprasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        $cercanas = $em->getRepository('CiudadBundle:city')->findCercanas(
            $user->getCiudad()->getId()
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        $cercanas = $em->getRepository('CiudadBundle:Ciudad')->findCercanas(
            $usuario->getCiudad()->getId()
=======
        $cercanas = $em->getRepository('AppBundle:Ciudad')->findCercanas(
            $usuario->getCiudad()->getId()
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
        );

        $compras = $em->getRepository('UsuarioBundle:user')->findTodasLasCompras($user->getId());

        return $this->render('usuario/compras.html.twig', array(
            'compras'  => $compras,
            'cercanas' => $cercanas
        ));
    }

    /**
<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Registra una nueva purchase de la offer indicada por parte del user logueado
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
     * Registra una nueva compra de la oferta indicada por parte del usuario logueado
=======
     * @Route("/{ciudad}/ofertas/{slug}/comprar", name="comprar")
     * Registra una nueva compra de la oferta indicada por parte del usuario logueado
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
     *
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer
     */
    public function comprarAction(Request $peticion, $city, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        // Solo pueden comprar los usuarios registrados y logueados
        if (null == $user || !$this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->getFlashBag()->add('info',
                'Antes de comprar debes registrarte o conectarte con tu user y password.'
            );

            return $this->redirect($this->generateUrl('usuario_login'));
        }

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        // Comprobar que existe la city indicada
        $city = $em->getRepository('CiudadBundle:city')->findOneBySlug($city);
        if (!$city) {
            throw $this->createNotFoundException('La city indicada no está disponible');
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        // Comprobar que existe la ciudad indicada
        $ciudad = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        if (!$ciudad) {
            throw $this->createNotFoundException('La ciudad indicada no está disponible');
=======
        // Comprobar que existe la ciudad indicada
        $ciudad = $em->getRepository('AppBundle:Ciudad')->findOneBySlug($ciudad);
        if (!$ciudad) {
            throw $this->createNotFoundException('La ciudad indicada no está disponible');
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
        }

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        // Comprobar que existe la offer indicada
        $offer = $em->getRepository('OfertaBundle:offer')->findOneBy(array('city' => $city->getId(), 'slug' => $slug));
        if (!$offer) {
            throw $this->createNotFoundException('La offer indicada no está disponible');
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        // Comprobar que existe la oferta indicada
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOneBy(array('ciudad' => $ciudad->getId(), 'slug' => $slug));
        if (!$oferta) {
            throw $this->createNotFoundException('La oferta indicada no está disponible');
=======
        // Comprobar que existe la oferta indicada
        $oferta = $em->getRepository('AppBundle:Oferta')->findOneBy(array('ciudad' => $ciudad->getId(), 'slug' => $slug));
        if (!$oferta) {
            throw $this->createNotFoundException('La oferta indicada no está disponible');
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
        }

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        // Un mismo user no puede comprar dos veces la misma offer
        $sale = $em->getRepository('OfertaBundle:sale')->findOneBy(array(
            'offer'  => $offer->getId(),
            'user' => $user->getId()
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        // Un mismo usuario no puede comprar dos veces la misma oferta
        $venta = $em->getRepository('OfertaBundle:Venta')->findOneBy(array(
            'oferta'  => $oferta->getId(),
            'usuario' => $usuario->getId()
=======
        // Un mismo usuario no puede comprar dos veces la misma oferta
        $venta = $em->getRepository('AppBundle:Venta')->findOneBy(array(
            'oferta'  => $oferta->getId(),
            'usuario' => $usuario->getId()
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
        ));

        if (null != $sale) {
            $fechaVenta = $sale->getFecha();

            $formateador = \IntlDateFormatter::create(
                $this->get('translator')->getLocale(),
                \IntlDateFormatter::LONG,
                \IntlDateFormatter::NONE
            );

            $this->get('session')->getFlashBag()->add('error',
                'No puedes volver a comprar la misma offer (la compraste el '.$formateador->format($fechaVenta).').'
            );

            return $this->redirect(
                $peticion->headers->get('Referer', $this->generateUrl('portada'))
            );
        }

        // Guardar la nueva sale e incrementar el contador de compras de la offer
        $sale = new sale();

        $sale->setOferta($offer);
        $sale->setUsuario($user);
        $sale->setFecha(new \DateTime());

        $em->persist($sale);

        $offer->setCompras($offer->getCompras()+1);

        $em->flush();

<<<<<<< HEAD:src/Cupon/UsuarioBundle/Controller/DefaultController.php
        return $this->render('UsuarioBundle:Default:comprar.html.twig', array(
            'offer'  => $offer,
            'user' => $user
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/Cupon/UsuarioBundle/Controller/DefaultController.php
        return $this->render('UsuarioBundle:Default:comprar.html.twig', array(
            'oferta'  => $oferta,
            'usuario' => $usuario
=======
        return $this->render('usuario/comprar.html.twig', array(
            'oferta'  => $oferta,
            'usuario' => $usuario
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle):src/AppBundle/Controller/UsuarioController.php
        ));
    }
}
