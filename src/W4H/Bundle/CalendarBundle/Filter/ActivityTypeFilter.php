<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class ActivityTypeFilter extends AbstractEntityFilter
{
    public function getFilterName()      { return 'activity_type'; }
    public function getEntityClass()     { return 'W4HEventTaskBundle:ActivityType'; }
    public function getFilterFormLabel() { return 'Activity Type'; }
}
