<?php

namespace W4H\Bundle\CalendarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class W4HCalendarExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (!isset($config['schedule_start']))
            throw new \InvalidArgumentException('The "w4h_calendar.schedule_start" option must be set.');
        $container->setParameter('w4h_calendar.schedule_start', $config['schedule_start']);

        if (!isset($config['schedule_limit']))
            throw new \InvalidArgumentException('The "w4h_calendar.schedule_limit" option must be set.');
        $container->setParameter('w4h_calendar.schedule_limit', $config['schedule_limit']);

        if (!isset($config['schedule_step']))
            throw new \InvalidArgumentException('The "w4h_calendar.schedule_step" option must be set.');
        $container->setParameter('w4h_calendar.schedule_step', $config['schedule_step']);

        $container->setParameter('w4h_calendar.schedule_default_year', isset($config['schedule_default_year']) ? $config['schedule_default_year'] : date('Y'));
        $container->setParameter('w4h_calendar.schedule_default_month', isset($config['schedule_default_month']) ? $config['schedule_default_month'] : date('m'));
        $container->setParameter('w4h_calendar.schedule_default_day', isset($config['schedule_default_day']) ? $config['schedule_default_day'] : date('d'));

        $container->setParameter('w4h_calendar.schedule_row_height', $config['schedule_row_height']);
        $container->setParameter('w4h_calendar.schedule_column_width', $config['schedule_column_width']);
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/';
    }

    public function getNamespace()
    {
        return "w4h_calendar";
    }
}
