<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use W4H\Bundle\CalendarBundle\Model\Calendar;
use W4H\Bundle\CalendarBundle\Form\CalendarFilterType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="calendar")
     */
    public function indexAction()
    {
        $response = $this->forward('W4HCalendarBundle:Default:displayDate', array(
            'year'  => 2012,
            'month' => 4,
            'day'   => 16
        ));

        return $response;
    }

    /**
     * @Route("/renderCSS/{step}", name="calendar_render_css")
     * @Template("W4HCalendarBundle:Default:calendar.css.twig")
     */
    public function renderCSSAction($step, $columns = 20)
    {
        $min = 0;
        $max = 24;

        $rows  = ($max - $min) * 60 / $step;

        return array(
          'rows' => $rows,
          'columns' => $columns
        );
    }

    /**
     * @Route("/calendar/{year}/{month}/{day}", name="calendar_show")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function displayDateAction($year, $month, $day)
    {
        $calendar = $this->container->get('w4h_calendar.calendar');
        $date = Calendar::formatedDay($year, $month, $day);
        $datetime = new \DateTime(date($date));

        $step = $this->container->getParameter('w4h_calendar.schedule_step');
        $form  = $this->createForm(new CalendarFilterType());

        return array(
            'day'       => array('year' => $year, 'month' => $month, 'day' => $day),
            'form'      => $form->createView(),
            'schedules' => $calendar->getSchedules(),
            'calendar'  => $calendar->getCalendar($datetime, $step),
            'step'      => $step
        );
    }

    /**
     * @Route("/calendar/{year}/{month}/{day}/filter", name="calendar_filter")
     * @Template("W4HCalendarBundle:Default:calendar.html.twig")
     */
    public function displayDateFilterAction($year, $month, $day)
    {
        $date = Calendar::formatedDay($year, $month, $day);
        $datetime = new \DateTime(date($date));

        $filters = null;
        $calendar = $this->container->get('w4h_calendar.calendar');
        $step = $this->container->getParameter('w4h_calendar.schedule_step');

        $request = $this->getRequest();
        $form    = $this->createForm(new CalendarFilterType());
        $form->bindRequest($request);
        if ($form->isValid())
        {
            $filters  = $form->getData();
        }

        return array(
            'day'       => array('year' => $year, 'month' => $month, 'day' => $day),
            'form'      => $form->createView(),
            'schedules' => $calendar->getSchedules(),
            'calendar'  => $calendar->getCalendar($datetime, $step, $filters),
            'step'      => $step
        );
    }
}
