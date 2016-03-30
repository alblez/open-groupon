<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Muestra el form de contacto y también procesa el envío de emails.
     *
     * @Route("/contacto", defaults={ "_locale"="es" }, name="contacto")
     */
    public function contactoAction(Request $request)
    {
        // Se creates un form "in situ", sin clase asociada
        $form = $this->createFormBuilder()
            ->add('remitente', 'Symfony\Component\Form\Extension\Core\Type\EmailType')
            ->add('message', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $datos = $form->getData();

            $contenido = sprintf(" Remitente: %s \n\n message: %s \n\n Navegador: %s \n address IP: %s \n",
                $datos['remitente'],
                htmlspecialchars($datos['message']),
                $request->server->get('HTTP_USER_AGENT'),
                $request->server->get('REMOTE_ADDR')
            );

            $message = \Swift_Message::newInstance()
                ->setSubject('Contacto')
                ->setFrom($datos['remitente'])
                ->setTo('contacto@cupon')
                ->setBody($contenido)
            ;

            $this->container->get('mailer')->send($message);
            $this->get('session')->setFlash('info', 'Tu message se ha enviado correctamente.');

            return $this->redirectToRoute('portada');
        }

        return $this->render('sitio/contacto.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
