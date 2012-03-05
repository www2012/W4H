<?php
namespace W4H\Bundle\CalendarBundle\Form;

use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;
use W4H\Bundle\CalendarBundle\Form\CalendarFilterType;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class UserCalendarFilterType extends CalendarFilterType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('role')
            ->remove('person')
        ;
    }

    public function getName()
    {
        return 'user_calendar_filters';
    }
}
