<?php

namespace App\EventSubscriber;

use App\Entity\Planning;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
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

        $planningsToDisplay = $this->em->getRepository(Planning::class)->findBy(['consultant' => $_POST['userId']]);

        $this->displayEvents($calendar, $planningsToDisplay);
    }

    public function displayEvents(CalendarEvent $calendar, array $planningsToDisplay)
    {
        foreach ($planningsToDisplay as $planning) {
            $calendar->addEvent(
                new Event(
                    $planning->getType(),
                    $planning->getDateStart(),
                    $planning->getDateEnd()
                )
            );
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
        }
    }

    function isDateBetweenTwoDates(\DateTime $date, \DateTime $start, \DateTime $end)
    {
        return $date >= $start && $date <= $end;
    }
}
