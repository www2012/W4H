<?php
namespace W4H\Bundle\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

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
            ->add('event', 'entity', array(
                'class'    => 'W4HEventTaskBundle:Event',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->findAllOrderedByNameQueryBuilder();
                },
                'label'    => 'Context',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
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
            ->add('location', 'entity', array(
                'class'    => 'W4HLocationBundle:Location',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->findAllOrderedByNameQueryBuilder();
                },
                'label'    => 'Location',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('activity', 'entity', array(
                'class'    => 'W4HEventTaskBundle:Activity',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->findAllOrderedByNameQueryBuilder();
                },
                'label'    => 'Activity',
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
