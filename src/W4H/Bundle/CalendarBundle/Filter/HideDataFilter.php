<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class HideDataFilter extends AbstractFilter
{
    public function getFilterName()      { return 'hidden_data'; }
    public function getFilterFormType()  { return 'choice'; }

    public function getFilterFormOptions()
    {
        return array(
          'choices'   => array(
            'symbols'              => 'Symbols',
            'activity_name'        => 'Activity Name',
            'activity_type'        => 'Activity Type',
            'activity_description' => 'Activity Description',
            'location'             => 'Location',
            'event'                => 'Event',
            'presensation'         => 'Presentation',
            'owners'               => 'Owners'
          ),
          'multiple'  => true,
          'expanded'  => true
        );
    }

    public function getFilteredData()
    {
        return array();
    }
}
