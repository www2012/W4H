<?php

namespace W4H\Bundle\PaperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PaperPresenterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('person')
            ->add('paper')
            ->add('task')
        ;
    }

    public function getName()
    {
        return 'w4h_bundle_paperbundle_paperpresentertype';
    }
}
