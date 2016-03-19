<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Listener del evento SecurityInteractive que se utiliza para redireccionar
 * al user recién logueado a la portada de su city.
 */
class LoginListener
{
    private $checker, $router, $city = null;

    public function __construct(AuthorizationChecker $context, Router $router)
    {
        $this->checker = $context;
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $this->city = $token->getUser()->getCiudad()->getSlug();
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (null != $this->city) {
            if ($this->checker->isGranted('ROLE_TIENDA')) {
                $portada = $this->router->generate('extranet_portada');
            } else {
                $portada = $this->router->generate('portada', array(
                    'city' => $this->city,
                ));
            }

            $event->setResponse(new RedirectResponse($portada));
            $event->stopPropagation();
        }
    }
}
