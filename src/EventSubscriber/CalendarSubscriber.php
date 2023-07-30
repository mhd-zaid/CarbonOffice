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
        
        if (isset($_POST['userId'])) {
            $planningsToDisplay = $this->em->getRepository(Planning::class)->findBy(['consultant'=>$_POST['userId']]);
            $consultant = $this->em->getRepository(User::class)->find($_POST['userId']); 
            $planningsToDisplay[] = $consultant->getDispenses();
        }else{
            $planningsToDisplay = $this->em->getRepository(Dispense::class)->findAll();
        }
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
                    $event = new Event(
                        "Formation: ".$formation->getFormation()->getTitle(),
                        $startEvent,
                        $endEvent
                    );
                    $calendar->addEvent($event);
                    $consultants = [];
                    foreach($formation->getConsultants() as $consultant)
                    {
                        $consultants[] = $consultant->getFullname();
                    }
                    $event->addOption('extendedProps', [
                        'id' => $formation->getId(),
                        'type' => 'formation',
                        'title' => $formation->getFormation()->getTitle(),
                        'description' => $formation->getFormation()->getDescription(),
                        'skills' => $formation->getFormation()->getSkills(),
                        'duration' => $formation->getFormation()->getDuration(),
                        'startTime' => $formation->getStartTime(),
                        'date' => $formation->getDate(),
                        'link' => $formation->getLink(),
                        'mentor' => $formation->getMentor()->getConsultant()->getFullname(),
                        'consultants' => $consultants,
                        'formation' => $formation->getFormation(),
                    ]);
                }
            }elseif($planning instanceof Dispense)
            {
                $startEvent = new \DateTime($planning->getDate()->format('Y-m-d').' '.$planning->getStartTime()->format('H:i:s'));
                $endEvent = (clone $startEvent)->add(new \DateInterval('PT'.$planning->getFormation()->getDuration().'M'));
                    $event = new Event(
                        "Formation: ".$planning->getFormation()->getTitle(),
                        $startEvent,
                        $endEvent
                    );
                    $calendar->addEvent($event);
                    $consultants = [];
                    foreach($planning->getConsultants() as $consultant)
                    {
                        $consultants[] = $consultant->getFullname();
                    }
                    $event->addOption('extendedProps', [
                        'id' => $planning->getId(),
                        'type' => 'formation',
                        'title' => $planning->getFormation()->getTitle(),
                        'description' => $planning->getFormation()->getDescription(),
                        'skills' => $planning->getFormation()->getSkills(),
                        'duration' => $planning->getFormation()->getDuration(),
                        'startTime' => $planning->getStartTime(),
                        'date' => $planning->getDate(),
                        'link' => $planning->getLink(),
                        'mentor' => $planning->getMentor()->getConsultant()->getFullname(),
                        'consultants' => $consultants,
                        'formation' => $planning->getFormation(),
                    ]);
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
            } 
            elseif($event->getTitle() === 'Work') {
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
