<?php

namespace W4H\Bundle\PaperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PaperType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('paper_number')
            ->add('title')
            ->add('authors')
        ;
    }

    public function getName()
    {
        return 'w4h_bundle_paperbundle_papertype';
    }
}
