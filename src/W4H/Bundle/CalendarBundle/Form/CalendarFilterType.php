<?php
namespace W4H\Bundle\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class CalendarFilterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('event', 'entity', array(
                'class'    => 'W4HEventTaskBundle:Event',
                'label'    => 'Context',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('activity_type', 'entity', array(
                'class'    => 'W4HEventTaskBundle:ActivityType',
                'label'    => 'Activity type',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('activity', 'entity', array(
                'class'    => 'W4HEventTaskBundle:Activity',
                'label'    => 'Activity',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('role', 'entity', array(
                'class'    => 'W4HEventTaskBundle:Role',
                'label'    => 'Role',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('location', 'entity', array(
                'class'    => 'W4HLocationBundle:Location',
                'label'    => 'Location',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
        ;
    }

    public function getName()
    {
        return 'store_bundle_adbundle_calendarfiltertype';
    }
}