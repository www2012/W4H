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
        $day = new \DateTime(date("2012-02-10"));
        $schedules = $this->getSchedules();
        $step = $this->container->getParameter('w4h_calendar.schedule_step');
        $form  = $this->createForm(new CalendarFilterType());

        return array(
          'form'      => $form->createView(),
          'schedules' => $schedules,
          'tasks'     => $this->getCalendar($day, $step)
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
     * @param integer $step
     * @return array task indexed by location and schedule
     *
     *  ex:
     *  array("location_id1" => array(
     *      "schedule_start"                 => array() | array(TaskObj, ...),
     *      "schedule_start + schedule_step" => array() | array(TaskObj, ...),
     *      "...."                           => array() | array(TaskObj, ...)
     *      "schedule_limit"                 => array() | array(TaskObj, ...)
     *  )
     *
     * Note : schedule_start format Y-m-d-H-i
     */
    private function getCalendar(\DateTime $day, $step)
    {
        $calendar = array();
        $daily_located_tasks = $this->getDailyTasksByLocations($day, $step);
        $locations = $this->getDoctrine()->getRepository('W4HLocationBundle:Location')->findAll();
        foreach($locations as $location)
        {
            foreach($this->getSchedules($day) as $date_format => $schedule)
            {
                if(isset($daily_located_tasks[$location->getId()][$date_format]))
                    $calendar[$location->getId()][$date_format] = $daily_located_tasks[$location->getId()][$date_format];
                else
                    $calendar[$location->getId()][$date_format] = array();
            }
        }

        return $calendar;
    }

    /**
     * @param DateTime $day
     * @param integer $step
     * @return array tasks indexed by location and schedule
     *
     *  ex:
     *  array("location_id1" => array(
     *      "Y-m-d-H-i" => array(TaskObj1, TaskObj2, TaskObj3, ...),
     *      "Y-m-d-H-i" => array(TaskObj1, TaskObj2, TaskObj3, ...)
     *  )
     */
    private function getDailyTasksByLocations(\DateTime $day, $step)
    {
        $daily_located_tasks = array();
        $starts_at = date('Y-m-d', $day->getTimestamp());
        // Can be optimized ?
        $tasks =  $this->getDoctrine()->getEntityManager()
            ->createQuery('SELECT task FROM W4HEventTaskBundle:Task task WHERE SUBSTRING(task.starts_at, 1, 10) = ?0')
            ->setParameters(array($starts_at))
            ->getResult();

        foreach($tasks as $task)
        {
            $daily_located_tasks[$task->getLocation()->getId()][Calendar::formatScheduleByStep($task->getStartsAt(), $step)][] = $task;
        }

        return $daily_located_tasks;
    }

    /**
     * @param DateTime $datetime
     * @return array schedules
     *
     *  ex: if $datetime == null
     *
     *  array(
     *      "10-00" => array("is_hour" => true),
     *      "15-30" => array("is_hour" => false)
     *  )
     *
     *  ex: if $datetime != null
     *
     *  array(
     *      "2012-02-10-10-00" => array("is_hour" => true),
     *      "2012-02-10-15-30" => array("is_hour" => false)
     *  )
     */
    private function getSchedules(\DateTime $datetime = null)
    {
        $index_format = $datetime ? "Y-m-d-H-i" : "H-i";

        $year = $month = $day = 0;
        if($datetime)
        {
            $year  = date('Y', $datetime->getTimestamp());
            $month = date('m', $datetime->getTimestamp());
            $day   = date('d', $datetime->getTimestamp());
        }

        $start = $this->container->getParameter('w4h_calendar.schedule_start');
        $limit = $this->container->getParameter('w4h_calendar.schedule_limit');
        $step  = $this->container->getParameter('w4h_calendar.schedule_step');
        $rows = range($start*60, $limit*60, $step);

        $schedules = array();
        foreach($rows as $row)
        {
            $hour = floor($row/60);
            $min = $row%60;
            $date = mktime($hour, $min, 0, $month, $day, $year);
            $i = date($index_format, $date);
            $schedules[$i]['is_hour'] = $min == 0;
        }

        return $schedules;
    }
}