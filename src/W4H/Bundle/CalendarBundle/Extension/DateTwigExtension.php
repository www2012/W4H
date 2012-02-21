<?php

namespace W4H\Bundle\CalendarBundle\Extension;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class DateTwigExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'path_previous_day' => new \Twig_Function_Method($this, 'pathPreviousDay'),
            'path_next_day'     => new \Twig_Function_Method($this, 'pathNextDay')
        );
    }

    /**
     * Return previous day for calendar path
     * 
     * @param string $name
     * @param array  $arguments
     * @return route
     */
    public function pathPreviousDay($name, array $arguments)
    {
        return $this->path($name, $arguments);
    }

    /**
     * Return next day for calendar path
     * 
     * @param string $name
     * @param array  $arguments
     * @return route
     */
    public function pathNextDay($name, array $arguments)
    {
        return $this->path($name, $arguments);
    }

    /**
     * Returns the name of the extension
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'date_twig_extension';
    }
}
