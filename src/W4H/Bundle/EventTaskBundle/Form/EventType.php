<?php

namespace W4H\Bundle\EventTaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('website_url', 'url')
            ->add('starts_on', 'date')
            ->add('ends_on', 'date')
        ;
    }

    public function getName()
    {
        return 'w4h_eventtaskbundle_eventtype';
    }
}
