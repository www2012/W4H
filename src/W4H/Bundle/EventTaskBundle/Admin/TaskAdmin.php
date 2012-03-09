<?php
namespace W4H\Bundle\EventTaskBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use W4H\Bundle\EventTaskBundle\Form\TaskOwnerType;

class TaskAdmin extends Admin
{
    protected $maxPerPage = 50;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('starts_at')
            ->add('ends_at')
            ->add('activity')
            ->add('event')
            ->add('location')
            ->add('room_configuration', 'choice', array(
                'choices'   => array('class' => 'Class', 'conference' => 'Conference')
            ))
            ->add('owners', 'sonata_type_collection',
                array(
                  'required' => false,
                  'by_reference' => false
                ),
                array(
                  'edit' => 'inline',
                  'inline' => 'table',
                  'sortable'  => 'person',
                  'targetEntity'=> 'W4H\Bundle\EventTaskBundle\Entity\TaskOwner'
                )
            )
            ->add('paper_presenters', 'sonata_type_collection',
                array(
                  'required' => false,
                  'by_reference' => false
                ),
                array(
                  'edit' => 'inline',
                  'inline' => 'table',
                  'sortable'  => 'person',
                  'targetEntity'=> 'W4H\Bundle\PaperBundle\Entity\PaperPresenter'
                )
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('starts_at')
            //->add('ends_at')
            ->add('activity')
            ->add('event')
            ->add('location')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('starts_at')
            ->add('ends_at')
            ->addIdentifier('activity')
            ->addIdentifier('event')
            ->addIdentifier('location')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
    }

    public function preUpdate($object)
    {
        foreach($object->getOwners() as $owner)
        {
          if(!$owner->getTask())
            $owner->setTask($object);
        }

        foreach($object->getPaperPresenters() as $paperPresenter)
        {
          if(!$paperPresenter->getTask())
            $paperPresenter->setTask($object);
        }
    }

    public function prePersist($object)
    {
        foreach($object->getOwners() as $owner)
        {
            $owner->setTask($object);
        }

        foreach($object->getPaperPresenters() as $paperPresenter)
        {
            $paperPresenter->setTask($object);
        }
    }
}
