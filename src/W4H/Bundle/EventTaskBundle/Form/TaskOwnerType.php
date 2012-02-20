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

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'W4H\Bundle\EventTaskBundle\Entity\TaskOwner',
        );
    }

    public function getName()
    {
        return 'w4h_eventtaskbundle_taskownertype';
    }
}
