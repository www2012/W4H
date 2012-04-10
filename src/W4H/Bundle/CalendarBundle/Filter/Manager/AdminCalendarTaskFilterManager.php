<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class AdminCalendarTaskFilterManager extends CalendarTaskFilterManager
{
    /**
     * getData
     *
     * @param array $filteredData
     * @return array
     */
    public function getFilteredData($filteredData = array())
    {
        $datas = array();
        foreach($this->getFilters() as $k => $filter)
        {
            if(isset($filteredData[$k]) && count($filteredData[$k]) > 0)
                $datas[$k] = $filteredData[$k];
            elseif(!in_array($k, array('role', 'person')))
                $datas[$k] = $filter->getFilteredData();
        }

        return $datas;
    }
}
