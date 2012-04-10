<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class EventFilter extends AbstractEntityFilter
{
    public function getFilterName()      { return 'event'; }
    public function getEntityClass()     { return 'W4HEventTaskBundle:Event'; }
    public function getFilterFormLabel() { return 'Event'; }
}
