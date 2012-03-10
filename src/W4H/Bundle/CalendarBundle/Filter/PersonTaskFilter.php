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
class PersonTaskFilter extends EntityTaskFilter
{
    public function getFilterName()      { return 'person'; }
    public function getEntityClass()     { return 'W4HUserBundle:Person'; }
    public function getFilterFormLabel() { return 'Person'; }
}
