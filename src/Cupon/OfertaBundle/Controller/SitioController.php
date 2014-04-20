<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SitioController extends Controller
{
    /**
     * Muestra el form de contacto y también procesa el envío de emails
     *
     */
    public function contactoAction(Request $peticion)
    {
        // Se creates un form "in situ", sin clase asociada
        $form = $this->createFormBuilder()
            ->add('remitente', 'email')
            ->add('message', 'textarea')
            ->getForm()
        ;

        $form->handleRequest($peticion);

        if ($form->isValid()) {
            $datos = $form->getData();

            $contenido = sprintf(" Remitente: %s \n\n message: %s \n\n Navegador: %s \n address IP: %s \n",
                $datos['remitente'],
                htmlspecialchars($datos['message']),
                $peticion->server->get('HTTP_USER_AGENT'),
                $peticion->server->get('REMOTE_ADDR')
            );

            $message = \Swift_Message::newInstance()
                ->setSubject('Contacto')
                ->setFrom($datos['remitente'])
                ->setTo('contacto@cupon')
                ->setBody($contenido)
            ;

            $this->container->get('mailer')->send($message);

            $this->get('session')->setFlash('info',
                'Tu message se ha enviado correctamente.'
            );

            return $this->redirect($this->generateUrl('portada'));
        }

        return $this->render('OfertaBundle:Sitio:contacto.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
