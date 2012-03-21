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
    public function getFilterName()      { return 'hide_data'; }
    public function getFilterFormType()  { return 'choice'; }

    public function getFilterFormOptions()
    {
        return array(
          'label'     => 'Hide Data',
          'choices'   => array(
            'symbols'              => 'Symbols',
            'activity_name'        => 'Activity Name',
            'activity_type'        => 'Activity Type',
            'activity_description' => 'Activity Description',
            'location'             => 'Location',
            'event'                => 'Event',
            'presentation'         => 'Presentation',
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
