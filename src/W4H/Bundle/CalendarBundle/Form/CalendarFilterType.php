<?php
namespace W4H\Bundle\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;
use W4H\Bundle\EventTaskBundle\Form\TaskType;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class CalendarFilterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('activity_type', 'entity', array(
                'class'    => 'W4HEventTaskBundle:ActivityType',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->findAllOrderedByNameQueryBuilder();
                },
                'label'    => 'Activity type',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('role', 'entity', array(
                'class'    => 'W4HUserBundle:Role',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->findAllOrderedByNameQueryBuilder();
                },
                'label'    => 'Role',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('person', 'entity', array(
                'class'    => 'W4HUserBundle:Person',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->findAllOrderedByLastNameQueryBuilder();
                },
                'label'    => 'Person',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
        ;
    }

    public function getName()
    {
        return 'calendar_filters';
    }
}
