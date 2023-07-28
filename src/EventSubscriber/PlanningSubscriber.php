<?php

namespace App\EventSubscriber;

use App\Entity\Planning;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class PlanningSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher,private Security $security,private EntityManagerInterface $em){}

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof Planning) {
            $eventsByConsultant = $this->em->getRepository(Planning::class)->findBy([
                'consultant'=>$_GET['userId']]
            );
            foreach ($eventsByConsultant as $event) {
                if ($object->getType() === 'Leave' && ($this->isDateBetweenTwoDates($object->getDateStart(), $event->getDateStart(), $event->getDateEnd()) || $this->isDateBetweenTwoDates($object->getDateEnd(), $event->getDateStart(), $event->getDateEnd()))) {
                    if ($event->getType() === 'Work') {
                        $this->splitEvent($event, $object);
                    }
                }
            }
            $object->setConsultant($this->security->getUser());
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if ($object instanceof Planning) {
            $eventsByConsultant = $this->em->getRepository(Planning::class)->findBy([
                'consultant'=>$_GET['userId']]
            );
            foreach ($eventsByConsultant as $event) {
                if ($object->getType() === 'Leave' && ($this->isDateBetweenTwoDates($object->getDateStart(), $event->getDateStart(), $event->getDateEnd()) || $this->isDateBetweenTwoDates($object->getDateEnd(), $event->getDateStart(), $event->getDateEnd()))) {
                    if ($event->getType() === 'Work') {
                        $this->splitEvent($event, $object);
                    }
                }
            }
            $object->setConsultant($this->security->getUser());
        }
    }

    private function isDateBetweenTwoDates(\DateTime $date, \DateTime $start, \DateTime $end) {
        return $date >= $start && $date <= $end;
    }

    private function splitEvent(Planning $event, Planning $newEvent) {
        $eventSplit = clone $event;
        $eventSplit->setId(null);
        $eventSplit->setDateEnd($newEvent->getDateStart()->modify('-1 day'));
        
        $eventSplit2 = clone $event;
        $eventSplit2->setId(null);
        $eventSplit2->setDateStart($newEvent->getDateEnd()->modify('+1 day'));
        
        $this->em->getRepository(Planning::class)->remove($event,true);
        $this->em->getRepository(Planning::class)->save($eventSplit,true);
        $this->em->getRepository(Planning::class)->save($eventSplit2,true);
    }
      
}