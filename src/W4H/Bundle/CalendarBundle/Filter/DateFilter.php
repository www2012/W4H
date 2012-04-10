<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class DateFilter extends AbstractFilter
{
    public function getFilterName()      { return $this->getOption('filter_name') ? $this->getOption('filter_name') : 'date'; }
    public function getFilterFormType()  { return 'date'; }
    public function getDefaultDay()      { return $this->getOption('default_day') ? $this->getOption('default_day') : new \DateTime('now'); }

    public function getFilterFormOptions()
    {
        return array(
            'label'    => $this->getOption('filter_form_label') ? $this->getOption('filter_form_label') : 'Date',
            'format' => 'yyyy-MM-dd',
            'widget' => 'single_text',
            'data' => $this->getDefaultDay()
        );
    }

    public function getFilteredData($filteredData = null)
    {
        if($filteredData != null)
            return parent::getFilteredData($filteredData);

        return $this->getDefaultDay();
    }
}
