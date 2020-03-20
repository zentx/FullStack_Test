<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;


class UserPasswordSubscriber implements EventSubscriberInterface
{
    public function cryptPassword(ViewEvent $event)
    {
        $entity = $event->getControllerResult();
        
        if($entity instanceof User){
            $entity->setPassword($this->passwordEncoder->encodePassword(
                $entity,
                $entity->getPassword()
            ));
        }

    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.view' => 'onKernelView',
        ];
    }
}
