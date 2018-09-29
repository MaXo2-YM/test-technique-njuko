<?php

namespace Classement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ClassementController extends AbstractActionController
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        return new ViewModel();
    }

    public function indexAction()
    {
        $events = $this->entityManager->getRepository('Application\Entity\Event')->findAll();

        return new ViewModel(
            array(
                "events" => $events
            )
        );
    }
    public function eventAction()
    {
        $eventId = (int) $this->params()->fromRoute('event-id', 0);
        $sex = $this->params()->fromRoute('sex', null);
        $event = $this->entityManager->getRepository('Application\Entity\Event')->find($eventId);
        
        $search = ['event' => $event];
        if($sex)
        {
            $search['sex'] = $sex;
        }
        $participants = $this->entityManager->getRepository('Application\Entity\Participant')->findBy($search);

        return new ViewModel(
            array(
                "event" => $event,
                "participants" => $participants,
                "sex" => $sex
            )
        );
    }
}
