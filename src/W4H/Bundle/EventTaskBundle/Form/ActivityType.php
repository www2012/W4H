<?php

namespace W4H\Bundle\EventTaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('activity_type')
        ;
    }

    public function getName()
    {
        return 'w4h_eventtaskbundle_activitytype';
    }
}
