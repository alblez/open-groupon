<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/{city}", defaults={ "city" = "%app.ciudad_por_defecto%" }, name="portada")
     * @Cache(smaxage="60")
     *
     * Muestra la portada del sitio web.
     *
     * @param string $city El slug de la city activa en la application
     * @return Response
     * @throws NotFoundHttpException
     */
    public function portadaAction($city)
    {
        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('AppBundle:offer')->findOfertaDelDia($city);

        if (!$offer) {
            throw $this->createNotFoundException('No se ha encontrado ninguna offer del día en la city seleccionada');
        }

        return $this->render('sitio/portada.html.twig', array(
            'offer' => $offer,
        ));
    }

    /**
     * @Route("/contacto", defaults={ "_locale"="es" }, name="contacto")
     *
     * Muestra el form de contacto y también procesa el envío de emails.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function contactoAction(Request $request)
    {
        // Se creates un form "in situ", sin clase asociada
        $form = $this->createFormBuilder()
            ->add('remitente', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array('label' => 'Tu address de email'))
            ->add('message', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
            ->add('enviar', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'Enviar message'))
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
