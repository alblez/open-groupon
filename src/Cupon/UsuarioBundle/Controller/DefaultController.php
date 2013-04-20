<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Cupon\UsuarioBundle\Entity\user;
use Cupon\OfertaBundle\Entity\sale;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioPerfilType;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioRegistroType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{
    /**
     * Muestra el form de login
     */
    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('UsuarioBundle:Default:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }

    /**
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

        $response = $this->render('UsuarioBundle:Default:cajaLogin.html.twig', array(
            'id'      => $id,
            'user' => $user
        ));

        $response->setMaxAge(30);

        return $response;
    }

    /**
     * Muestra el form para que se registren los nuevos usuarios. Además
     * se encarga de procesar la información y de guardar la información en la base de datos
     */
    public function registroAction()
    {
        $peticion = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $user = new user();
        $user->setPermiteEmail(true);

        $form = $this->createForm(new UsuarioRegistroType(), $user);

        if ($peticion->getMethod() == 'POST') {
            $form->bind($peticion);

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
                $token = new UsernamePasswordToken($user, $user->getPassword(), 'usuarios', $user->getRoles());
                $this->container->get('security.context')->setToken($token);

                return $this->redirect($this->generateUrl('portada', array(
                    'city' => $user->getCiudad()->getSlug()
                )));
            }
        }

        return $this->render('UsuarioBundle:Default:record.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Muestra el form con toda la información del perfil del user logueado.
     * También permite modificar la información y saves los cambios en la base de datos
     */
    public function perfilAction()
    {
        $peticion = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new UsuarioPerfilType(), $user);

        if ($peticion->getMethod() == 'POST') {
            $passwordOriginal = $form->getData()->getPassword();

            $form->bindRequest($peticion);

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

                $this->get('session')->setFlash('info',
                    'Los datos de tu perfil se han actualizado correctamente'
                );

                return $this->redirect($this->generateUrl('usuario_perfil'));
            }
        }

        return $this->render('UsuarioBundle:Default:perfil.html.twig', array(
            'user'    => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * Muestra todas las compras del user logueado
     */
    public function comprasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $cercanas = $em->getRepository('CiudadBundle:city')->findCercanas(
            $user->getCiudad()->getId()
        );

        $compras = $em->getRepository('UsuarioBundle:user')->findTodasLasCompras($user->getId());

        return $this->render('UsuarioBundle:Default:compras.html.twig', array(
            'compras'  => $compras,
            'cercanas' => $cercanas
        ));
    }

    /**
     * Registra una nueva purchase de la offer indicada por parte del user logueado
     *
     * @param string $city El slug de la city a la que pertenece la offer
     * @param string $slug   El slug de la offer
     */
    public function comprarAction($city, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        // Solo pueden comprar los usuarios registrados y logueados
        if (null == $user || !$this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->setFlash('info',
                'Antes de comprar debes registrarte o conectarte con tu user y password.'
            );

            return $this->redirect($this->generateUrl('usuario_login'));
        }

        // Comprobar que existe la city indicada
        $city = $em->getRepository('CiudadBundle:city')->findOneBySlug($city);
        if (!$city) {
            throw $this->createNotFoundException('La city indicada no está disponible');
        }

        // Comprobar que existe la offer indicada
        $offer = $em->getRepository('OfertaBundle:offer')->findOneBy(array('city' => $city->getId(), 'slug' => $slug));
        if (!$offer) {
            throw $this->createNotFoundException('La offer indicada no está disponible');
        }

        // Un mismo user no puede comprar dos veces la misma offer
        $sale = $em->getRepository('OfertaBundle:sale')->findOneBy(array(
            'offer'  => $offer->getId(),
            'user' => $user->getId()
        ));

        if (null != $sale) {
            $fechaVenta = $sale->getFecha();

            $formateador = \IntlDateFormatter::create(
                $this->get('translator')->getLocale(),
                \IntlDateFormatter::LONG,
                \IntlDateFormatter::NONE
            );

            $this->get('session')->setFlash('error',
                'No puedes volver a comprar la misma offer (la compraste el '.$formateador->format($fechaVenta).').'
            );

            return $this->redirect(
                $this->getRequest()->headers->get('Referer', $this->generateUrl('portada'))
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

        return $this->render('UsuarioBundle:Default:comprar.html.twig', array(
            'offer'  => $offer,
            'user' => $user
        ));
    }

    /**
     * Da de baja al user actualmente conectado borrando su información
     * de la base de datos
     */
    public function bajaAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        if (null == $user ||
            !$this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->setFlash('info',
                'Para darte de baja primero tienes que conectarte.'
            );

            return $this->redirect($this->generateUrl('usuario_login'));
        }

        $this->get('request')->getSession()->invalidate();
        $this->get('security.context')->setToken(null);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('portada'));
    }
}
