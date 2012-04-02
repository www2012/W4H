<?php
namespace W4H\Bundle\UserBundle\Admin\Entity;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseAdmin;

class UserAdmin extends BaseAdmin
{
    protected $maxPerPage = 50;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('username')
                ->add('email')
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
                ->add('has_private_data')
            ->end()
            ->with('Management')
                ->add('roles', 'sonata_security_roles', array( 'multiple' => true, 'required' => false))
                ->add('locked', null, array('required' => false))
                ->add('expired', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
                ->add('credentialsExpired', null, array('required' => false))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('first_name')
            ->add('last_name')
            ->add('organisation')
            ->add('country_iso_code')
            ->add('locked')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('first_name')
            ->add('last_name')
            ->add('organisation')
            ->add('mobile_phone')
            ->add('freeset')
            ->add('country_iso_code')
            ->add('has_private_data')
            ->add('enabled')
            ->add('locked')
            ->add('createdAt')
        ;

        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $listMapper
                ->add('impersonating', 'string', array('template' => 'SonataUserBundle:Admin:Field/impersonating.html.twig'))
            ;
        }
    }

    public function getExportFields()
    {
        return array(
          'username',
          'email',
          'first_name',
          'last_name',
          'organisation',
          'service',
          'other_mail',
          'mobile_phone',
          'website_url',
          'freeset',
          'socials_account',
          'country_iso_code',
          'has_private_data'
        );
    }

    public function validate(ErrorElement $errorElement, $object)
    {
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
