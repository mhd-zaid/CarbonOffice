<?php

namespace App\EventSubscriber;

use App\Entity\Dispense;
use App\Entity\Planning;
use App\Entity\User;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {

        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $planningsToDisplay = [];
                        
        $planningsToDisplay = $this->em->getRepository(Planning::class)->findBy(['consultant'=>$_POST['userId']]);
        $consultant = $this->em->getRepository(User::class)->find($_POST['userId']); 
        $planningsToDisplay[] = $consultant->getDispenses();
        $this->displayEvents($calendar, $planningsToDisplay);
    }

    public function displayEvents(CalendarEvent $calendar, array $planningsToDisplay)
    {
        foreach ($planningsToDisplay as $planning) {
            if($planning instanceof Planning)
            {
                $calendar->addEvent(
                    new Event(
                        $planning->getType(),
                        $planning->getDateStart(),
                        $planning->getDateEnd()
                    )
                );
            }elseif($planning instanceof Collection)
            {
                foreach($planning as $formation)
                {   
                    $startEvent = new \DateTime($formation->getDate()->format('Y-m-d').' '.$formation->getStartTime()->format('H:i:s'));
                    $endEvent = (clone $startEvent)->add(new \DateInterval('PT'.$formation->getFormation()->getDuration().'M'));
                    $calendar->addEvent(
                        new Event(
                            "Formation: ".$formation->getFormation()->getTitle(),
                            $startEvent,
                            $endEvent
                        )
                    );
                }
            }
        }
        foreach ($calendar->getEvents() as $event) {
            if ($event->getTitle() === 'Leave') {
                $event->addOption(
                    'backgroundColor',
                    '#E53F49'
                );
                $event->addOption(
                    'borderColor',
                    '#E53F49'
                );
            } elseif ($event->getTitle() === 'Work') {
                $event->addOption(
                    'backgroundColor',
                    '#5B98D2'
                );
                $event->addOption(
                    'borderColor',
                    '#5B98D2'
                );
            }
            else{
                $event->addOption(
                    'backgroundColor',
                    '#FD8D14'
                );
                $event->addOption(
                    'borderColor',
                    '#FD8D14'
                );
            }
        }
    }

    function isDateBetweenTwoDates(\DateTime $date, \DateTime $start, \DateTime $end)
    {
        return $date >= $start && $date <= $end;
    }
}
