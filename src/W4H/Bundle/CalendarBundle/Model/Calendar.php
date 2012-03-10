<?php
namespace W4H\Bundle\CalendarBundle\Model;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class Calendar
{
    protected $container;
    protected $em;

    public function __construct($container, $em)
    {
        $this->container = $container;
        $this->em = $em;
    }

    /**
     * formatScheduleByStep
     *
     * @param DateTime $datetime
     * @param integer $step (in minutes)
     * @return string
     */
    public static function formatScheduleByStep(\DateTime $datetime, $step)
    {
        // Date
        $year  = date('Y', $datetime->getTimestamp());
        $month = date('m', $datetime->getTimestamp());
        $day   = date('d', $datetime->getTimestamp());

        // Time
        $hour   = date('H', $datetime->getTimestamp());
        $minute = str_pad(((floor(date('i', $datetime->getTimestamp()) / $step)) * $step), 2, 0);

        return sprintf("%s-%s-%s-%s-%s", $year, $month, $day, $hour, $minute);
    }

    /**
     * formatedDay
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @return string formated day like Y-m-d ex: 2012-02-16
     */
    public static function formatedDay($year, $month, $day)
    {
        return sprintf("%s-%s-%s",
            $year,
            str_pad($month, 2, 0, STR_PAD_LEFT),
            str_pad($day, 2, 0, STR_PAD_LEFT)
        );
    }

    /**
     * @param DateTime $day
     * @param integer  $step
     * @param array    $filters
     * @param boolean  $display_empty_location
     *
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
    public function getCalendar(\DateTime $day, $step, $filters = array(), $display_empty_location = false)
    {
        $calendar = array();
        $daily_located_tasks = $this->getDailyTasksByLocations($day, $step, $filters);

        $locations = array();
        if(!empty($filters['location'][0]))
        {
            $location_ids = array();
            foreach($filters['location'] as $location)
                $location_ids[] = $location->getId();

            $locations = $this->em->getRepository('W4HLocationBundle:Location')->findById($location_ids);
        }
        else
        {
            $locations = $this->em->getRepository('W4HLocationBundle:Location')->findAllOrderedByName();
        }

        foreach($locations as $location)
        {
            if($display_empty_location || isset($daily_located_tasks[$location->getId()]))
            {
                if(!isset($calendar[$location->getId()]))
                    $calendar[$location->getId()] = array('object' => $location, 'schedules' => array());

                foreach($this->getSchedules($day) as $date => $schedule)
                {
                    $tasks = array();
                    if(isset($daily_located_tasks[$location->getId()][$date]))
                        $tasks = $daily_located_tasks[$location->getId()][$date];

                    $calendar[$location->getId()]['schedules'][$date] = array(
                        'is_hour' => $schedule['is_hour'],
                        'tasks'   => $tasks
                    );
                }
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
     *  ))
     */
    public function getDailyTasksByLocations(\DateTime $day, $step, $filters = array())
    {
        $daily_located_tasks = array();
        $starts_at = date('Y-m-d', $day->getTimestamp());

        $tasks = $this->em->getRepository('W4HEventTaskBundle:Task')
            ->findAllFiltered($starts_at, $filters);

        foreach($tasks as $task)
        {
            $daily_located_tasks[$task->getLocation()->getId()][self::formatScheduleByStep($task->getStartsAt(), $step)][] = $task;
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
    public function getSchedules(\DateTime $datetime = null)
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

    /**
     * Find all tasks sort by Event
     *
     * @param array    $filters
     * @return array of Task
     *
     * array(
     *   '20120416' => array(
     *     'display' => 'April 16, 2012'
     *     'hours'   => array(
     *     '0900AM' => array(
     *       'display' => '09:00 AM'
     *         'tasks'   => TaskCollection,
     *       )
     *     )
     *   )
     * );
     */
    public function getEventTasks($filters = array())
    {
        $ret = array();
        $tasks = $this->em->getRepository('W4HEventTaskBundle:Task')
            ->findAllFilteredOrderByDate($filters);

        foreach($tasks as $task)
        {
            if(!isset($ret[$task->getStartsAt()->format('Ymd')]))
            {
              $ret[$task->getStartsAt()->format('Ymd')] = array(
                  'display' => $task->getStartsAt()->format('F d, Y'),
                  'hours'   => array(),
              );
            }

            if(!isset($ret[$task->getStartsAt()->format('Ymd')]['hours'][$task->getStartsAt()->format('HiA')]))
            {
              $ret[$task->getStartsAt()->format('Ymd')]['hours'][$task->getStartsAt()->format('HiA')] = array(
                  'display' => $task->getStartsAt()->format('H:i A'),
                  'tasks'   => array(),
              );
            }

            $ret[$task->getStartsAt()->format('Ymd')]['hours'][$task->getStartsAt()->format('HiA')]['tasks'][] = $task;
        }

        return $ret;
    }
}
