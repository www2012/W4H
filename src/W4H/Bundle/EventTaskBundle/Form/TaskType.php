<?php

namespace W4H\Bundle\EventTaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('starts_at', 'datetime')
            ->add('ends_at', 'datetime')
            ->add('activity', 'entity', array(
                'class'    => 'W4HEventTaskBundle:Activity',
                'label'    => 'Activity',
                'required' => true,
                'expanded' => false,
                'multiple' => false
            ))
            ->add('event', 'entity', array(
                'class'    => 'W4HEventTaskBundle:Event',
                'label'    => 'Event',
                'required' => true,
                'expanded' => false,
                'multiple' => false
            ))
            ->add('location', 'entity', array(
                'class'    => 'W4HLocationBundle:Location',
                'label'    => 'Location',
                'required' => true,
                'expanded' => false,
                'multiple' => false
            ))
            ->add('room_configuration', 'choice', array(
                'choices'   => array('class' => 'Class', 'conference' => 'Conference'),
                'required'  => false
            ))
        ;
    }

    public function getName()
    {
        return 'w4h_eventtaskbundle_tasktype';
    }
}
