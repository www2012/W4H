<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\EntityTaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class ActivityTaskFilter extends EntityTaskFilter
{
    public function getFilterName()      { return 'activity'; }
    public function getEntityClass()     { return 'W4HEventTaskBundle:Activity'; }
    public function getFilterFormLabel() { return 'Activity'; }
}
