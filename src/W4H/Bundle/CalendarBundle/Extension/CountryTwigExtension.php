<?php

namespace W4H\Bundle\CalendarBundle\Extension;

use Symfony\Component\Locale\Locale;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class CountryTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'country' => new \Twig_Filter_Method($this, 'countryFilter'),
        );
    }

    public static function countryFilter($country)
    {
        $countries = Locale::getDisplayCountries(
            \Locale::getDefault()
        );

        return $countries[$country];
    }

    public function getName()
    {
        return 'country_twig_extension';
    }
}
