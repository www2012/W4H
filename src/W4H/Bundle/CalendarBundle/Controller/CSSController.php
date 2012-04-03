<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use W4H\Bundle\CalendarBundle\Tool\Utils;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class CSSController extends Controller
{
    /**
     * @Route("/css/grid-{step}.css", name="css_render_grid")
     * @Template("W4HCalendarBundle:CSS:grid.css.twig")
     */
    public function renderGridAction($step, $columns)
    {
        $min = 0;
        $max = 24;

        $rows  = ($max - $min) * 60 / $step;

        return array(
          'rows'            => $rows,
          'rowHeight'       => $this->container->getParameter('w4h_calendar.schedule_row_height'),
          'columns'         => $columns,
          'columnWidth'     => $this->container->getParameter('w4h_calendar.schedule_column_width'),
          'events'          => $this->getEventsBG(),
          'activity_types'  => $this->getActivityTypesBG()
        );
    }

    /**
     * @Route("/css/symbol.css", name="css_render_symbol")
     * @Template("W4HCalendarBundle:CSS:symbol.css.twig")
     */
    public function renderSymbolAction()
    {
        return array(
          'events'          => $this->getEventsBG(),
          'activity_types'  => $this->getActivityTypesBG()
        );
    }

    public function getEventsBG()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $events = $em->getRepository('W4HEventTaskBundle:Event')->findAll();
        $eventsBG = array();

        $colors = self::makeColorGradient(0.6, 0.6, 0.6, 0, 2, 4, count($events), 100, 60);
        foreach($events as $k => $event)
            $eventsBG[Utils::slugify($event->getName())] = $colors[$k];

        return $eventsBG;
    }

    public function getActivityTypesBG()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $types = $em->getRepository('W4HEventTaskBundle:ActivityType')->findAll();
        $typesBG = array();

        $freq = pi()*2/(count($types)+1);
        $colors = self::makeColorGradient($freq, $freq, $freq, 0, 2, 4, count($types), 200, 40);
        foreach($types as $k => $type)
            $typesBG[Utils::slugify($type->getName())] = $colors[$k];

        return $typesBG;
    }

    public static function makeColorGradient($freq1, $freq2, $freq3, $phase1, $phase2, $phase3, $len = 10, $center = 128, $width = 127)
    {
        $colors = array();
        $red = $grn = $blu = 0;

        for ($i = 0; $i < $len; $i++)
        {
           $red = sin($freq1 * $i + $phase1) * $width + $center;
           $grn = sin($freq2 * $i + $phase2) * $width + $center;
           $blu = sin($freq3 * $i + $phase3) * $width + $center;
           $colors[$i] = self::RGB2Color($red, $grn, $blu);
        }

        return $colors;
    }

    public static function RGB2Color($r, $g, $b)
    {
        return sprintf('#%s%s%s',
            str_pad(dechex($r), '2', '0'),
            str_pad(dechex($g), '2', '0'),
            str_pad(dechex($b), '2', '0')
        );
    }
}
