<?php
namespace W4H\Bundle\CalendarBundle\Tool;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class Tool
{
    /**
     * urlize the given word
     *
     * @param string $word
     * @param string $sep the separator
     *
     * @return string
     */
    public static function urlize($word, $sep = '_')
    {
        return strtolower(preg_replace('/[^a-z0-9_]/i', $sep.'$1', $word));
    }

}
