<?php

namespace W4H\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
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
            ->add('has_private_data', array('label' => 'Hide my contact data'))
        ;
    }

    public function getName()
    {
        return 'w4h_userbundle_persontype';
    }
}
