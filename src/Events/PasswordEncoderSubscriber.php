<?php

namespace App\Events;

use Symfony\Component\HttpKernel\KernelEvents;

use App\Entity\User;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface{
    /**
     * Le hasher pour hash pour encoder le mot de passe
     * @var UserPasswordHasherInterface
     */
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
       $this->hasher = $hasher;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['hashPassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function hashPassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($user instanceof User && $method === 'POST'){
            $hash = $this->hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
        }
    }
}