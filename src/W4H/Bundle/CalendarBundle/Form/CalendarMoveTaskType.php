<?php
namespace W4H\Bundle\CalendarBundle\Form;

use Symfony\Component\Form\FormBuilder;
use W4H\Bundle\EventTaskBundle\Form\TaskType;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class CalendarMoveTaskType extends TaskType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('ends_at')
            ->remove('activity')
            ->remove('event')
        ;
    }

    public function getName()
    {
        return 'calendar_move_task';
    }
}
