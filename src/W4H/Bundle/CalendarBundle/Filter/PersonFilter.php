<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class PersonFilter extends AbstractEntityFilter
{
    public function getFilterName()      { return 'person'; }
    public function getEntityClass()     { return 'W4HUserBundle:Person'; }
    public function getFilterFormLabel() { return 'Person'; }
}
