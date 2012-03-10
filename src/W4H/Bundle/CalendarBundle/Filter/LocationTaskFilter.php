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
class LocationTaskFilter extends EntityTaskFilter
{
    public function getFilterName()      { return 'location'; }
    public function getEntityClass()     { return 'W4HLocationBundle:Location'; }
    public function getFilterFormLabel() { return 'Location'; }
}
