<?php
namespace W4H\Bundle\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class MailingType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('to', 'choice', array(
                'choices'  => $options['data']->getTo(),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('subject', 'text')
            ->add('message', 'textarea')
            ->add('filtered_data', 'hidden')
        ;
    }

    public function getName()
    {
        return 'mailing';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'W4H\Bundle\CalendarBundle\Model\Mailing',
        );
    }
}
