<?php

namespace App\Events;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


class UserEvents implements EventSubscriberInterface
{
    protected $em;
    
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::POST_PERSIST => ['postUserCreate'],
            EasyAdminEvents::POST_UPDATE => ['postUserUpdate']
        ];
    }

    public function postUserCreate(GenericEvent $entity)
    {
        
        $ent = get_class($entity->getSubject());
        if($ent == User::class)
        {
            $rol = $entity->getSubject()->getRole()->getName();
            $id = $entity->getSubject()->getId();
            $password = $entity->getSubject()->getPassword();
            $user = $this->em->getRepository(User::class)->find($id);
            $encoded = $this->encoder->encodePassword($user, $password);
            $data = array($rol);
            $user->setRoles($data);
            $user->setPassword($encoded);
            $this->em->flush();
        }
        

    }

    public function postUserUpdate(GenericEvent $entity)
    {
        
        $ent = get_class($entity->getSubject());
        if($ent == User::class)
        {
            $rol = $entity->getSubject()->getRole()->getName();
            $id = $entity->getSubject()->getId();
            $password = $entity->getSubject()->getPassword();
            $user = $this->em->getRepository(User::class)->find($id);
            $data = array($rol);
            $user->setRoles($data);
            if(!(strlen($password) == 96 && preg_match('/^\$argon2i\$/', $password)))
            {
                $encoded = $this->encoder->encodePassword($user, $password);
                $user->setPassword($encoded);
                
            }
            $this->em->flush();
            
        }
    }

}
