<?php
namespace W4H\Bundle\UserBundle\Admin\Entity;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseAdmin;

class UserAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->with('General')
                ->add('first_name')
                ->add('last_name')
                ->add('organisation')
                ->add('service')
                ->add('other_mail')
                ->add('mobile_phone')
                ->add('website_url')
                ->add('freeset')
                ->add('socials_account')
                ->add('country_iso_code', 'country')
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('first_name')
            ->add('last_name')
            ->add('organisation')
            ->add('country_iso_code')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->addIdentifier('first_name')
            ->addIdentifier('last_name')
            ->addIdentifier('organisation')
            ->addIdentifier('mobile_phone')
            ->addIdentifier('freeset')
            ->addIdentifier('country_iso_code')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        parent::validate($errorElement, $object);
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
