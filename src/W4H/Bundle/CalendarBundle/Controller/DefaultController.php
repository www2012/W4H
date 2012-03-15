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
use W4H\Bundle\CalendarBundle\Filter\Manager\PublicCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\PersonalCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\AdminCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\EventListTaskFilterManager;

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

        $filterManager = new PublicCalendarTaskFilterManager($this->container, array(
            'default_day' => $this->getScheduleDefaultDateTime()
        ));
        $form = $filterManager->createForm();
        $filteredData = array();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                return $this->renderCalendar($filteredData, $form, $form_action);
            }
            $filteredData = $form->getData();
        }

        return $this->renderCalendar($filterManager->getFilteredData($filteredData), $form, $form_action);
    }

    /**
     * @Route("/calendar/me", name="calendar_user")
     */
    public function myCalendarAction(Request $request)
    {
        $form_action = 'calendar_user';

        $user   = $this->container->get('security.context')->getToken()->getUser();

        $filterManager = new PersonalCalendarTaskFilterManager($this->container, array(
            'default_day' => $this->getScheduleDefaultDateTime(),
            'user_id'     => $user->getId()
        ));
        $form = $filterManager->createForm();
        $filteredData = array();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                return $this->renderCalendar($filteredData, $form, $form_action);
            }
            $filteredData = $form->getData();
        }

        return $this->renderCalendar($filterManager->getFilteredData($filteredData), $form, $form_action);
    }

    /**
     * @Route("/calendar/all", name="calendar_admin")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function adminCalendarAction(Request $request)
    {
        $form_action = 'calendar_admin';

        $filterManager = new AdminCalendarTaskFilterManager($this->container, array(
            'default_day' => $this->getScheduleDefaultDateTime()
        ));
        $form = $filterManager->createForm();
        $filteredData = array();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                return $this->renderCalendar($filteredData, $form, $form_action, true);
            }
            $filteredData = $form->getData();
        }

        return $this->renderCalendar($filterManager->getFilteredData($filteredData), $form, $form_action, true);
    }

    /**
     * @Route("/event-list", name="event_list")
     */
    public function eventListAction(Request $request)
    {
        $form_action = 'event_list';
        $from_day = $this->getScheduleDefaultDateTime();
        $to_day   = $this->getScheduleDefaultDateTime();
        $to_day->modify('+5 day');

        $filterManager = new EventListTaskFilterManager($this->container, array(
            'from_day' => $from_day,
            'to_day' => $to_day
        ));

        $form = $filterManager->createForm();
        $filteredData = array();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                return $this->renderEventList($filteredData, $form, $form_action);
            }
            $filteredData = $form->getData();
        }

        return $this->renderEventList($filterManager->getFilteredData($filteredData), $form, $form_action);
    }

    protected function getScheduleDefaultDateTime()
    {
        $year  = $this->container->getParameter('w4h_calendar.schedule_default_year');
        $month = $this->container->getParameter('w4h_calendar.schedule_default_month');
        $day   = $this->container->getParameter('w4h_calendar.schedule_default_day');

        return new \DateTime(sprintf('%d-%d-%d', $year, $month, $day));
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
     * @Route("/calendar/move-task/{task_id}", name="calendar_move_task")
     */
    public function moveTaskAction($task_id)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if($user->isSuperAdmin())
        {
            $request  = $this->getRequest();
            $em       = $this->getDoctrine()->getEntityManager();
            $task     = $em->getRepository('W4HEventTaskBundle:Task')->find($task_id);
            $interval = date_diff($task->getStartsAt(), $task->getEndsAt());

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

    public function renderCalendar($filteredData, $form, $form_action, $display_empty_location = false)
    {
        $calendar = $this->container->get('w4h_calendar.calendar');
        $step     = $this->container->getParameter('w4h_calendar.schedule_step');

        return $this->render('W4HCalendarBundle:Default:calendar.html.twig', array(
            'day'         => $filteredData['day'],
            'step'        => $step,
            'schedules'   => $calendar->getSchedules(),
            'calendar'    => $calendar->getCalendar($step, $filteredData, $display_empty_location),
            'form'        => $form->createView(),
            'form_action' => $form_action,
        ));
    }

    public function renderEventList($filteredData, $form, $form_action)
    {
        $calendar = $this->container->get('w4h_calendar.calendar');

        return $this->render('W4HCalendarBundle:Default:eventList.html.twig', array(
            'from'        => $filteredData['from'],
            'to'          => $filteredData['to'],
            'event_tasks' => $calendar->getEventTasks($filteredData),
            'form'        => $form->createView(),
            'form_action' => $form_action,
            'hidden_data' => $filteredData['hide_data']
        ));
    }
}

