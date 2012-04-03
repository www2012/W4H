<?php

namespace W4H\Bundle\EventTaskBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use W4H\Bundle\CalendarBundle\Tool\Utils;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/task/{task_id}/vcal", name="task_vcal")
     */
    public function taskVcalAction($task_id)
    {
        $em       = $this->getDoctrine()->getEntityManager();
        $task     = $em->getRepository('W4HEventTaskBundle:Task')->find($task_id);

        $filename = sprintf('%d-%s.%s', $task->getId(), Utils::slugify($task->getActivity()->getName()), 'ics');

        $response = new Response($task->getVcal());
        $response->headers->set('Content-Type', 'text/x-vCalendar');
        $response->headers->set('Content-Disposition', 'inline; filename='.$filename);

        return $response;
    }
}

