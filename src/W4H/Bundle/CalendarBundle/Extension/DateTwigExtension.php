<?php

namespace W4H\Bundle\CalendarBundle\Extension;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class DateTwigExtension extends \Twig_Extension
{
    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return array(
            'path_previous_day' => new \Twig_Function_Method($this, 'pathPreviousDay'),
            'path_next_day'     => new \Twig_Function_Method($this, 'pathNextDay'),
            'previous_day'      => new \Twig_Function_Method($this, 'getPreviousDay'),
            'next_day'      => new \Twig_Function_Method($this, 'getNextDay'),
        );
    }

    /**
     * Return previous day for calendar path
     * 
     * @param string $name
     * @param array  $arguments
     * @return route
     */
    public function pathPreviousDay($name, array $arguments)
    {
        $date = date('Y-m-d', mktime(0, 0, 0, $arguments['month'], $arguments['day'], $arguments['year']));
        $previous_time =  $this->shiftDate($date, "-1 day");

        return $this->router->generate($name, array(
            'year'  => $previous_time['year'],
            'month' => $previous_time['month'],
            'day'   => $previous_time['day']
        ));
    }

    /**
     * Return next day for calendar path
     * 
     * @param string $name
     * @param array  $arguments
     * @return route
     */
    public function pathNextDay($name, array $arguments)
    {
        $date = date('Y-m-d', mktime(0, 0, 0, $arguments['month'], $arguments['day'], $arguments['year']));
        $next_time =  $this->shiftDate($date, "+1 day");

        return $this->router->generate($name, array(
            'year'  => $next_time['year'],
            'month' => $next_time['month'],
            'day'   => $next_time['day']
        ));
    }

    /**
     * Return previous day for calendar
     * 
     * @param datetime $day
     * @return previous day
     */
    public function getPreviousDay($day)
    {
        return strtotime(date('Y-m-d', $day->getTimestamp())."-1 day");
    }

    /**
     * Return next day for calendar
     * 
     * @param datetime $day
     * @return next day
     */
    public function getNextDay($day)
    {
        return strtotime(date('Y-m-d', $day->getTimestamp())."+1 day");
    }

    /**
     * Return an array of day, month, year from a date with an offset
     * 
     * @param Date $date
     * @param string $offset
     * @return array('day', 'month', 'year')
     */
    private function shiftDate($date, $offset)
    {
        $new_time      = strtotime($date.$offset);
        $time['day']   = date('d', $new_time);
        $time['month'] = date('m', $new_time);
        $time['year']  = date('Y', $new_time);

        return $time;
    }
    
    
    /**
     * Returns the name of the extension
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'date_twig_extension';
    }
}
