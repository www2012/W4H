<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\TaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class DateTaskFilter extends TaskFilter
{
    public function getFilterName()      { return $this->getOption('filter_name') ? $this->getOption('filter_name') : 'date'; }
    public function getFilterFormType()  { return 'date'; }

    public function getDefaultDay()
    {
        $year  = $this->getContainer()->getParameter('w4h_calendar.schedule_default_year');
        $month = $this->getContainer()->getParameter('w4h_calendar.schedule_default_month');
        $day   = $this->getContainer()->getParameter('w4h_calendar.schedule_default_day');

        return new \DateTime(sprintf('%s-%s-%s', $year, $month, $day));
    }

    public function getFilterFormOptions()
    {
        return array(
            'label'    => $this->getOption('filter_form_label') ? $this->getOption('filter_form_label') : 'Date',
            'format' => 'yyyy-MM-dd',
            'widget' => 'single_text',
            'data' => $this->getDefaultDay()
        );
    }

    public function getFilteredData()
    {
        return $this->getDefaultDay();
    }
}
