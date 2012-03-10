<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use W4H\Bundle\CalendarBundle\Model\Calendar;
use W4H\Bundle\CalendarBundle\Form\CalendarFilterType;
use W4H\Bundle\CalendarBundle\Form\UserCalendarFilterType;
use W4H\Bundle\CalendarBundle\Form\CalendarMoveTaskType;
use W4H\Bundle\CalendarBundle\Form\TaskFilterType;
use W4H\Bundle\EventTaskBundle\Form\TaskType;
use W4H\Bundle\CalendarBundle\Filter\PublicCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\PersonalCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\CalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\EventListTaskFilterManager;


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
     * @Route("/", name="calendar")
     */
    public function indexAction(Request $request)
    {
        $form_action = 'calendar';

        $publicCalendar = new PublicCalendarTaskFilterManager($this->container);
        $form = $publicCalendar->createForm();
        $filters = $publicCalendar->getData();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                die('todo');
            }
            $filters = $form->getData();
            //var_dump($filters); die;
        }

        return $this->renderCalendar($filters, $form, $form_action);
    }

    /**
     * Return calendar filters
     */
    /*public function getCalendarFilters()
    {
        $em    = $this->getDoctrine()->getEntityManager();
        $activity_type = $em->getRepository('W4HEventTaskBundle:ActivityType')->findByName(array(
          'BarCamp',
          'BOF',
          'Conference Session',
          'Demo Tracks',
          'European Tracks',
          'Industrial Tracks',
          'Keynote',
          'Panel',
          'Party',
          'PhD Symp',
          'Scientific Tracks',
          'Transport',
          'Tutorial',
          'Workshop'
        ));

        return array('activity_type' => $activity_type);
    }*/

    /**
     * @Route("/calendar/me", name="calendar_user")
     */
    public function myCalendarAction()
    {
        $form_action = 'calendar_user';

        $personalCalendar = new PersonalCalendarTaskFilterManager($this->container);
        $form   = $personalCalendar->createForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                die('todo');
            }
        }

        $filters = $personalCalendar->getData();
        return $this->renderCalendar($filters, $form, $form_action);
    }

    /**
     * Return all filters matching a logged user
     */
    /*public function getMyCalendarFilters()
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $user   = $this->container->get('security.context')->getToken()->getUser();
        $person = $em->getRepository('W4HUserBundle:Person')->find($user->getId());

        return array('person' => array($person));
    }*/

    /**
     * @Route("/calendar/all", name="calendar_admin")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function adminCalendarAction()
    {
        $form_action = 'calendar_admin';

        $calendar = new CalendarTaskFilterManager($this->container);
        $form   = $calendar->createForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                die('todo');
            }
        }

        $filters = $calendar->getData();
        return $this->renderCalendar($form, $form_action, true);
    }

    /**
     * @Route("/renderCSS/{step}", name="calendar_render_css")
     * @Template("W4HCalendarBundle:Default:calendar.css.twig")
     */
    public function renderCSSAction($step, $columns)
    {
        $min = 0;
        $max = 24;

        $rows  = ($max - $min) * 60 / $step;

        return array(
          'rows'        => $rows,
          'rowHeight'   => $this->container->getParameter('w4h_calendar.schedule_row_height'),
          'columns'     => $columns,
          'columnWidth' => $this->container->getParameter('w4h_calendar.schedule_column_width'),
        );
    }

    /**
     * @Route("/event-list", name="event_list")
     */
    public function eventListAction(Request $request)
    {
        $form_action = 'event_list';

        $eventListManager = new EventListTaskFilterManager($this->container);
        $form   = $eventListManager->createForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                die('todo');
            }
        }

        $filters = $eventListManager->getData();
        return $this->renderEventList($filters, $form, $form_action);
    }

    /**
     * @Route("/calendar/move-task/{task_id}", name="calendar_move_task")
     */
    public function moveTaskAction($task_id)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if($user->isSuperAdmin())
        {
            $request = $this->getRequest();
            $em = $this->getDoctrine()->getEntityManager();
            $task = $em->getRepository('W4HEventTaskBundle:Task')->find($task_id);
            $interval      = date_diff($task->getStartsAt(), $task->getEndsAt());

            // is it an Ajax request?
            if($request->isXmlHttpRequest())
            {
                $starts_at   = $request->query->get('starts_at');
                $location_id = $request->query->get('location_id');

                $new_starts_at = \DateTime::createFromFormat('Y-m-d-H-i', $starts_at);
                $new_ends_at   = clone $new_starts_at;
                $new_ends_at->add($interval);

                $location = $em->getRepository('W4HLocationBundle:Location')->find($location_id);
                $task->setLocation($location);
                $task->setStartsAt($new_starts_at);
                $task->setEndsAt($new_ends_at);
                $em->persist($task);
                $em->flush();

                return $this->render(
                    'W4HCalendarBundle:Default:taskData.html.twig',
                    array('task' => $task)
                );
            }
            else
            {
                if($request->getMethod() == 'POST')
                {
                    $form = $this->createForm(new CalendarMoveTaskType(), $task);
                    $form->bindRequest($request);
                    if($form->isValid())
                    {
                        $new_starts_at = $task->getStartsAt();
                        $new_ends_at   = clone $new_starts_at;
                        $new_ends_at->add($interval);

                        $task->setEndsAt($new_ends_at);
                        $em->persist($task);
                        $em->flush();
                    }
                    return $this->redirect($this->generateUrl('calendar'));
                }
                else
                {
                    $form = $this->createForm(new CalendarMoveTaskType(), $task);
                    return $this->render(
                        'W4HCalendarBundle:Default:moveForm.html.twig',
                        array(
                            'form' => $form->createView(),
                            'task' => $task
                        )
                    );
                }
            }
        }
    }

    public function renderCalendar($filters, $form, $form_action, $display_empty_location = false)
    {
        $year   = $this->container->getParameter('w4h_calendar.schedule_default_year');
        $month  = $this->container->getParameter('w4h_calendar.schedule_default_month');
        $day    = $this->container->getParameter('w4h_calendar.schedule_default_day');

        /*$request = $this->getRequest();
        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            if ($form->isValid())
            {
                $filters = array_merge($filters, $form->getData());
            }
        }*/

        $calendar = $this->container->get('w4h_calendar.calendar');
        $step     = $this->container->getParameter('w4h_calendar.schedule_step');
        $date     = Calendar::formatedDay($year, $month, $day);
        $datetime = new \DateTime(date($date));

        return $this->render('W4HCalendarBundle:Default:calendar.html.twig', array(
            'day'       => array(
                'year'    => $year,
                'month'   => str_pad($month, 2, 0, STR_PAD_LEFT),
                'day'     => str_pad($day, 2, 0, STR_PAD_LEFT)
            ),
            'step'        => $step,
            'schedules'   => $calendar->getSchedules(),
            'calendar'    => $calendar->getCalendar($datetime, $step, $filters, $display_empty_location),
            'form'        => $form->createView(),
            'form_action' => $form_action,
        ));
    }

    public function renderEventList($filters, $form, $form_action)
    {
        $calendar = $this->container->get('w4h_calendar.calendar');

        return $this->render('W4HCalendarBundle:Default:eventList.html.twig', array(
            'day'       => array(
                'year'    => 2012,
                'month'   => 04,
                'day'     => 16	
            ),
            'event_tasks' => $calendar->getEventTasks($filters),
            'form'        => $form->createView(),
            'form_action' => $form_action,
        ));
    }
}

