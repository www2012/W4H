<?php

namespace W4H\Bundle\CalendarBundle\Extension;

use Symfony\Component\Locale\Locale;

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
