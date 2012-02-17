<?php
namespace W4H\Bundle\EventTaskBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class TaskAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('starts_at')
            ->add('ends_at')
            ->add('activity')
            ->add('event')
            ->add('location')
            ->add('owners', 'collection', array(
                'required' => false,
                'allow_add' => true,
                'by_reference' => false
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('activity')
            ->add('event')
            ->add('location')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('starts_at')
            ->addIdentifier('ends_at')
            ->addIdentifier('activity')
            ->addIdentifier('event')
            ->addIdentifier('location')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
    }
}
