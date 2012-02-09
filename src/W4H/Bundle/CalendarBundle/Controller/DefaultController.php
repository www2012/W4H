<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="calendar")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function indexAction()
    {
        //TODO:$tasks = getAll;
        //TODO:return array('tasks' => $this->getIndexedTasks($tasks));
        return array();
    }

    /**
     * @Route("/filter", name="calendar_filter")
     * @Method("post")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function filterAction()
    {
        $request = $this->getRequest();
        var_dump($request); die;
        $form    = $this->createForm(new CalendarFilterType());
        $form->bindRequest($request);
        if ($form->isValid())
        {
            $data  = $form->getData();
            $tasks = array();

            // TODO : request all tasks matching filter
            // $tasks = 
            //TODO:return array('tasks' => $this->getIndexedTasks($tasks));
            return array();
        }

        //TODO:$tasks = getAll;
        //TODO:return array('tasks' => $this->getIndexedTasks($tasks));
        return array();
    }

    /**
     * @param DoctrineCollection Task
     * @return array task indexed by location and schedule
     */
    private function getIndexedTasks($tasks)
    {
      return array();
    }
}
