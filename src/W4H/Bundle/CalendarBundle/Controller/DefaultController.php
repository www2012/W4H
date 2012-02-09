<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use W4H\Bundle\CalendarBundle\Model\Calendar;
use W4H\Bundle\CalendarBundle\Form\CalendarFilterType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="calendar")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function indexAction()
    {
        $schedules = $this->getSchedules();
        $locations = $this->getDoctrine()->getRepository('W4HLocationBundle:Location')->findAll();
        $day = new \DateTime(date("2012-02-16"));
        $form  = $this->createForm(new CalendarFilterType());

        return array(
          'form'      => $form->createView(),
          'schedules' => $schedules,
          'tasks'     => $this->getIndexedTasks($day, $locations)
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
     * @param DateTime $day
     * @param DoctrineCollection Location $locations
     * @return array task indexed by location and schedule
     */
    private function getIndexedTasks($day, $locations)
    {
        $indexed_tasks = array();
        // Return array of tasks group by schedule
        // TODO : $daily_located_tasks = getDailyLocatedTasks($day, $locations, $start = null, $limit = null, $step = null)
        foreach($locations as $location)
        {
            if(!isset($indexed_tasks[$location->getId()]))
                $indexed_tasks[$location->getId()] = array();

            foreach($this->getSchedules($day) as $datetime => $schedule)
            {
                // if(isset($daily_located_tasks[$datetime]))
                // $indexed_tasks[$location][$datetime] = $daily_located_tasks[$datetime]
                //else
                $indexed_tasks[$location->getId()][$datetime] = null;
            }
        }
        return $indexed_tasks;
    }

    /**
     * @param DateTime $day
     * @return array schedules
     */
    private function getSchedules($day = null)
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
