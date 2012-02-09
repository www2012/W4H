<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use W4H\Bundle\CalendarBundle\Model\Calendar;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="calendar")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function indexAction()
    {
        $tasks = $this->getDoctrine()->getRepository('W4HEventTaskBundle:Task')->findAll();
        return array('tasks' => $this->getIndexedTasks($tasks, 15));
    }

    /**
     * @Route("/filter", name="calendar_filter")
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
     * @param integer Step
     * @return array task indexed by location and schedule
     */
    private function getIndexedTasks($tasks, $step)
    {
        $indexed_tasks = array();
        foreach($tasks as $task)
        {
            $indexed_tasks[$task->getLocation()->getId()][Calendar::formatScheduleByStep($task->getStartsAt(), $step)] = $task->getId();
        }

        var_dump($indexed_tasks); die;
        return array();
    }
}
