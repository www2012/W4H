<?php

namespace W4H\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilder $builder, array $options)
    {
        parent::buildUserForm($builder, $options);
        $builder->add('username')
                ->add('email')
                ->add('organisation')
                ->add('service')
                ->add('other_mail')
                ->add('mobile_phone')
                ->add('website_url')
                ->add('freeset', 'hidden')
                ->add('socials_account', 'hidden')
                ->add('country_iso_code', 'country', array('label' => 'Country'))
                ->add('has_private_data')
        ;
    }

    public function getName()
    {
        return 'w4h_user_profile';
    }
}
