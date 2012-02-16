<?php
namespace W4H\Bundle\LocationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class LocationAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('building')
            ->add('level')
            ->add('class_room_places')
            ->add('conference_room_places')
            ->add('standing_room_places')
            ->add('video_projector')
            ->add('sound')
            ->add('internet')
            ->add('other_devices')
            ->add('accessibility')
            ->add('latitude')
            ->add('longitude')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('building')
            ->add('level')
            ->add('class_room_places')
            ->add('conference_room_places')
            ->add('standing_room_places')
            ->add('video_projector')
            ->add('sound')
            ->add('internet')
            ->add('other_devices')
            ->add('accessibility')
            ->add('latitude')
            ->add('longitude')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('building')
            ->addIdentifier('level')
            ->addIdentifier('class_room_places')
            ->addIdentifier('conference_room_places')
            ->addIdentifier('standing_room_places')
            ->addIdentifier('video_projector')
            ->addIdentifier('sound')
            ->addIdentifier('internet')
            ->addIdentifier('other_devices')
            ->addIdentifier('accessibility')
            ->addIdentifier('latitude')
            ->addIdentifier('longitude')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        // TODO !
        $errorElement
            ->with('name')
                ->assertMaxLength(array('limit' => 64))
            ->end()
            ->with('building')
                ->assertMaxLength(array('limit' => 128))
            ->end()
            ->with('level')
                ->assertMaxLength(array('limit' => 64))
            ->end()
        ;
    }
}
