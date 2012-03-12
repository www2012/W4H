<?php

namespace W4H\Bundle\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('w4h_calendar');

        $rootNode
            ->children()
                ->scalarNode('schedule_start')->defaultValue('8')->end()
                ->scalarNode('schedule_limit')->defaultValue('22')->end()
                ->scalarNode('schedule_step')->defaultValue('15')->end()
                ->scalarNode('schedule_default_year')->end()
                ->scalarNode('schedule_default_month')->end()
                ->scalarNode('schedule_default_day')->end()
                ->scalarNode('schedule_row_height')->defaultValue('12')->end()
                ->scalarNode('schedule_column_width')->defaultValue('100')->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
