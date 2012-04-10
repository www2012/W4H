<?php

namespace W4H\Bundle\EventTaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('query');
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'W4H\Bundle\EventTaskBundle\Model\Search');
    }

    public function getName()
    {
        return 'w4h_eventtaskbundle_searchtype';
    }
}
