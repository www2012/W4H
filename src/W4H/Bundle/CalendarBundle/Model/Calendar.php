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
    public static function formatScheduleByStep($datetime, $step)
    {
        // Step must be in [0, 60]
        $step = $step % 60;

        // Date
        $year  = date('Y', $datetime->getTimestamp());
        $month = date('m', $datetime->getTimestamp());
        $day   = date('d', $datetime->getTimestamp());

        // Time
        $hour   = date('H', $datetime->getTimestamp());
        $minute = str_pad(((floor(date('i', $datetime->getTimestamp()) / $step)) * $step), 2, 0);

        return sprintf("%s-%s-%s-%s-%s", $year, $month, $day, $hour, $minute);
    }
}

