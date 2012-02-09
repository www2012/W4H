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
        $schedules = $this->getSchedules();
        $tasks = $this->getDoctrine()->getRepository('W4HEventTaskBundle:Task')->findAll();

        return array(
          'schedules' => $schedules,
          'tasks' => $this->getIndexedTasks(
            $tasks,
            $this->container->getParameter('w4h_calendar.schedule_step')
          )
        );
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
            $indexed_tasks[$task->getLocation()->getId()][Calendar::formatScheduleByStep($task->getStartsAt(), $step)] = $task;
        }

        return $indexed_tasks;
    }

    /**
     * @return array schedules
     */
    private function getSchedules()
    {
        $start = $this->container->getParameter('w4h_calendar.schedule_start');
        $limit = $this->container->getParameter('w4h_calendar.schedule_limit');
        $step  = $this->container->getParameter('w4h_calendar.schedule_step');

        $schedules = array();
        $rows = range($start*60, $limit*60, $step);
        foreach($rows as $i => $row)
        {
            $hour = floor($row/60);
            $min = $row%60;
            $schedules[$i]['hour12'] = sprintf('%02d:%02d', $hour < 13 ? $hour : $hour-12, $min);
            $schedules[$i]['hour24'] = sprintf('%02d:%02d', $hour, $min);
            $schedules[$i]['is_hour'] = $min == 0;
        }
        return $schedules;
    }
}
