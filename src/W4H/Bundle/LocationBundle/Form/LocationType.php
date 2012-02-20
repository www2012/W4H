<?php

namespace W4H\Bundle\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('building')
            ->add('level')
            ->add('class_room_places')
            ->add('conference_room_places')
            ->add('standing_room_places')
            ->add('video_projector', null, array('required' => false))
            ->add('sound', null, array('required' => false))
            ->add('internet', null, array('required' => false))
            ->add('other_devices')
            ->add('accessibility')
            ->add('latitude')
            ->add('longitude')
        ;
    }

    public function getName()
    {
        return 'w4h_locationbundle_locationtype';
    }
}
