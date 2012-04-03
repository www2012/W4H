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
     * @Route("/renderCSS/{step}", name="calendar_render_css")
     * @Template("W4HCalendarBundle:Default:calendar.css.twig")
     */
    public function renderAction($step, $columns)
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
    
    public function getEventsBG()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $events = $em->getRepository('W4HEventTaskBundle:Event')->findAll();
        $eventsBG = array();
        foreach($events as $event)
        {
            $eventsBG[Utils::slugify($event->getName())] = self::generateColorFromString(Utils::slugify($event->getName()), 0, 3);
        }
        return $eventsBG;
    }
    
    public function getActivityTypesBG()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $types = $em->getRepository('W4HEventTaskBundle:ActivityType')->findAll();
        $typesBG = array();
        foreach($types as $type)
        {
            $typesBG[Utils::slugify($type->getName())] = self::generateColorFromString(Utils::slugify($type->getName()));
        }
        return $typesBG;
    }
    
    /*
     * Outputs a color (#000000) based on a string
     * 
     * $string = String
     * $min_brightness = Integer
     * $spec = Integer (determines how unique each color will be)
     */
    function generateColorFromString($string, $min_brightness = 100, $spec = 10)
    {	
        $hash = md5($string);
        $colors = array();

        // convert hash into 3 decimal values between 0 and 255
        for($i = 0; $i < 3; $i++)
            $colors[$i] = max(array(round(((hexdec(substr($hash,$spec*$i,$spec)))/hexdec(str_pad('',$spec,'F')))*255),$min_brightness));

        if($min_brightness > 0)
        {
            // loop until brightness is above or equal to min_brightness
            while(array_sum($colors)/3 < $min_brightness )
            {
                for($i = 0; $i < 3; $i++)
                    $colors[$i] += 10;	// increase each color by 10
            }
        }
 
        $output = '';
        for($i = 0; $i < 3; $i++)
            $output .= str_pad(dechex($colors[$i]),2,0,STR_PAD_LEFT);  // convert each color to hex and append to output

        return $output;
    }
}