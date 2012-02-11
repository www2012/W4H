<?php

namespace W4H\Bundle\EventTaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('starts_at')
            ->add('ends_at', 'datetime')
            ->add('activity', 'datetime')
            ->add('role')
            ->add('event')
            ->add('location')
            ->add('person')
        ;
    }

    public function getName()
    {
        return 'w4h_bundle_eventtaskbundle_tasktype';
    }
}
