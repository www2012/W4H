<?php
namespace W4H\Bundle\PaperBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class PaperPresenterAdmin extends Admin
{
    protected $maxPerPage = 50;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager('W4H\Bundle\UserBundle\Entity\Person');
        $person_query = $em->getRepository('W4HUserBundle:Person')->findAllOrderedByLastNameQuery();
        $em = $this->modelManager->getEntityManager('W4H\Bundle\PaperBundle\Entity\Paper');
        $paper_query = $em->getRepository('W4HPaperBundle:Paper')->findAllOrderedByTitleQuery();

        $formMapper
            ->add('person', 'sonata_type_model', array('query' => $person_query))
            ->add('paper', 'sonata_type_model', array('query' => $paper_query))
        ;

        if ($this->hasSubject()) {
            $formMapper->add('task');
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('person')
            ->add('paper')
            ->add('task')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('person')
            ->addIdentifier('paper')
            ->addIdentifier('task')
        ;
    }

    public function getExportFields()
    {
        return array(
          'person_email',
          'person_first_name',
          'person_last_name',
          'person_mobile_phone',
          'person_website_url',
          'person_country_iso_code',
          'paper_number',
          'paper_title',
          'paper_authors',
          'task_id',
          'task_starts_at',
          'task_name'
        );
    }

    public function validate(ErrorElement $errorElement, $object)
    {
    }
}
