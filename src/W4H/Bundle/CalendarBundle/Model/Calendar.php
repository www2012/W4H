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
}
