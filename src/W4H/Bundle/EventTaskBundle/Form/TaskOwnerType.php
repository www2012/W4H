<?php

namespace W4H\Bundle\EventTaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TaskOwnerType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('person')
            ->add('role')
            ->add('task')
        ;
    }

    public function getName()
    {
        return 'w4h_bundle_eventtaskbundle_taskownertype';
    }
}
