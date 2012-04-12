<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class ScheduleFilter extends AbstractFilter
{
    public function getFilterName()      { return $this->getOption('filter_name') ? $this->getOption('filter_name') : 'schedule'; }
    public function getFilterFormType()  { return 'date'; }
    public function getDefaultSchedule()
    {
        return $this->getOption('default_schedule') ? $this->getOption('default_schedule') : new \DateTime();
    }

    public function getFilterFormOptions()
    {
        return array(
            'label'  => $this->getOption('filter_form_label') ? $this->getOption('filter_form_label') : 'Schedule',
            'format' => 'yyyy-MM-dd HH:mm',
            'widget' => 'single_text',
            'data'   => $this->getDefaultSchedule()
        );
    }

    public function getDefaultFilteredData() { return $this->getDefaultSchedule(); }
}
