<?php

namespace W4H\Bundle\CalendarBundle\Extension;

use W4H\Bundle\CalendarBundle\Tool\Utils;

class SlugifyTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'slugify' => new \Twig_Filter_Method($this, 'slugifyFilter'),
        );
    }

    public function slugifyFilter($text)
    {
        return Utils::slugify($text);
    }

    public function getName()
    {
        return 'slugify_twig_extension';
    }
}
