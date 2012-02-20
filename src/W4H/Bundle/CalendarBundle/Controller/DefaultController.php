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
     */
    public function indexAction()
    {
        $response = $this->forward('W4HCalendarBundle:Default:displayDate', array(
            'year'  => 2012,
            'month' => 4,
            'day'   => 16
        ));

        return $response;
    }

    /**
     * @Route("/renderCSS/{step}", name="calendar_render_css")
     * @Template("W4HCalendarBundle:Default:calendar.css.twig")
     */
    public function renderCSSAction($step, $columns = 20)
    {
        $min = 0;
        $max = 24;

        $rows  = ($max - $min) * 60 / $step;

        return array(
          'rows' => $rows,
          'columns' => $columns
        );
    }

    /**
     * @Route("/calendar/{year}/{month}/{day}", name="calendar_show")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function displayDateAction($year, $month, $day)
    {
        $date = Calendar::formatedDay($year, $month, $day);
        $datetime = new \DateTime(date($date));

        $step = $this->container->getParameter('w4h_calendar.schedule_step');
        $form  = $this->createForm(new CalendarFilterType());

        return array(
            'day'       => array('year' => $year, 'month' => $month, 'day' => $day),
            'form'      => $form->createView(),
            'schedules' => $this->getSchedules(),
            'calendar'  => $this->getCalendar($datetime, $step),
            'step'      => $step
        );
    }

    /**
     * @Route("/calendar/{year}/{month}/{day}/filter", name="calendar_filter")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function displayDateFilterAction($year, $month, $day)
    {
        $date = Calendar::formatedDay($year, $month, $day);
        $datetime = new \DateTime(date($date));

        $filters = null;
        $schedules = $this->getSchedules();
        $step = $this->container->getParameter('w4h_calendar.schedule_step');

        $request = $this->getRequest();
        $form    = $this->createForm(new CalendarFilterType());
        $form->bindRequest($request);
        if ($form->isValid())
        {
            $filters  = $form->getData();
        }

        return array(
            'day'       => array('year' => $year, 'month' => $month, 'day' => $day),
            'form'      => $form->createView(),
            'schedules' => $schedules,
            'calendar'  => $this->getCalendar($datetime, $step, $filters),
            'step'      => $step
        );
    }

    /**
     * @param DateTime $day
     * @param integer  $step
     * @param array    $filters
     * @return array task indexed by location and schedule
     *
     *  ex:
     *  array("location_id1" => array(
     *    'object' => LocationObj,
     *    'schedules' => array(
     *      'schedule_start'                 => array(
     *        'tasks' => array() | array(TaskObj, ...),
     *        'is_hour' => true | false
     *      ),
     *      'schedule_start + schedule_step' => array(
     *        'tasks' => array() | array(TaskObj, ...),
     *        'is_hour' => true | false
     *      ),
     *      '....'                           => array(
     *        'tasks' => array() | array(TaskObj, ...),
     *        'is_hour' => true | false
     *      ),
     *      'schedule_limit'                 => array(
     *        'tasks' => array() | array(TaskObj, ...),
     *        'is_hour' => true | false
     *      )
     *    )
     *  )
     *
     * Note : schedules format Y-m-d-H-i
     */
    private function getCalendar(\DateTime $day, $step, array $filters = null)
    {
        $calendar = array();
        $daily_located_tasks = $this->getDailyTasksByLocations($day, $step, $filters);

        $locations = array();
        if(!empty($filters['locations'][0]))
        {
            $location_ids = array();
            foreach($filters['locations'] as $location)
                $location_ids[] = $location->getId();

            $locations = $this->getDoctrine()->getRepository('W4HLocationBundle:Location')->findById($location_ids);
        }
        else
        {
            $locations = $this->getDoctrine()->getRepository('W4HLocationBundle:Location')->findAll();
        }

        foreach($locations as $location)
        {
            if(!isset($calendar[$location->getId()]))
                $calendar[$location->getId()] = array('object' => $location, 'schedules' => array());

            foreach($this->getSchedules($day) as $date_format => $schedule)
            {
                $tasks = array();
                if(isset($daily_located_tasks[$location->getId()][$date_format]))
                    $tasks = $daily_located_tasks[$location->getId()][$date_format];

                $calendar[$location->getId()]['schedules'][$date_format] = array(
                    'is_hour' => $schedule['is_hour'],
                    'tasks' => $tasks
                );
            }
        }

        return $calendar;
    }

    /**
     * @param DateTime $day
     * @param integer  $step
     * @param array    $filters
     * @return array tasks indexed by location and schedule
     *
     *  ex:
     *  array("location_id1" => array(
     *      "Y-m-d-H-i" => array(TaskObj1, TaskObj2, TaskObj3, ...),
     *      "Y-m-d-H-i" => array(TaskObj1, TaskObj2, TaskObj3, ...)
     *  )
     */
    private function getDailyTasksByLocations(\DateTime $day, $step, array $filters = null)
    {
        $daily_located_tasks = array();
        $starts_at = date('Y-m-d', $day->getTimestamp());
        // Can be optimized ?
        $em = $this->getDoctrine()->getEntityManager();
        $tasks = $em->getRepository('W4HEventTaskBundle:Task')
                    ->withTaskOwners($starts_at, $filters);

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
