<?php
namespace W4H\Bundle\EventTaskBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class TaskOwnerAdmin extends Admin
{
    protected $maxPerPage = 50;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager('W4H\Bundle\UserBundle\Entity\Person');
        $query = $em->getRepository('W4HUserBundle:Person')->findAllOrderedByLastNameQuery();
        $formMapper
            ->add('person', 'sonata_type_model', array('query' => $query))
            ->add('role')
        ;

        if ($this->hasRequest()) {
            $formMapper->add('task');
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('person')
            ->add('role')
            ->add('task')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('person')
            ->addIdentifier('role')
            ->addIdentifier('task')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
    }
}
