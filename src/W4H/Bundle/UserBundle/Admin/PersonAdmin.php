<?php
namespace W4H\Bundle\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class PersonAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('first_name')
            ->add('last_name')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('first_name')
            ->add('last_name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('first_name')
            ->addIdentifier('last_name')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        // TODO !
        $errorElement
            ->with('first_name')
                ->assertMaxLength(array('limit' => 64))
            ->end()
            ->with('last_name')
                ->assertMaxLength(array('limit' => 64))
            ->end()
        ;
    }
}
