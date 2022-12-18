<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Security;

class JWTCreatedListener
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload       = $event->getData();
        $payload['id'] = $this->security->getUser()->getId();

        $event->setData($payload);
    }
}