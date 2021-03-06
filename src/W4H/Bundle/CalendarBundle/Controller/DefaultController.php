<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use W4H\Bundle\CalendarBundle\Model\Calendar;
use W4H\Bundle\CalendarBundle\Model\Mailing;
use W4H\Bundle\CalendarBundle\Form\CalendarMoveTaskType;
use W4H\Bundle\CalendarBundle\Form\TaskFilterType;
use W4H\Bundle\CalendarBundle\Form\MailingType;
use W4H\Bundle\EventTaskBundle\Form\TaskType;
use W4H\Bundle\CalendarBundle\Filter\Manager\PublicCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\PersonalCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\AdminCalendarTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\AdminEventListTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\EventListTaskFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\MailingFilterManager;
use W4H\Bundle\CalendarBundle\Filter\Manager\ScheduleTaskFilterManager;
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

        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
          $filterManager = new AdminEventListTaskFilterManager($this->container, array(
              'from_day' => $from_day,
              'to_day'   => $to_day
          ));
        }
        else
        {
          $filterManager = new EventListTaskFilterManager($this->container, array(
              'from_day' => $from_day,
              'to_day'   => $to_day
          ));
        }

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

    /**
     * @Route("/event-list/schedule", name="event_list_by_schedule")
     */
    public function eventListByScheduleAction(Request $request)
    {
        $form_action = 'event_list_by_schedule';

        $filterManager = new ScheduleTaskFilterManager($this->container);

        $form = $filterManager->createForm();
        $filteredData = array();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                return $this->renderEventListSchedule($filteredData, $form, $form_action);
            }
            $filteredData = $form->getData();
        }

        return $this->renderEventListSchedule($filterManager->getFilteredData($filteredData), $form, $form_action);
    }

    /**
     * @Route("/mailing", name="mailing")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function mailingAction(Request $request)
    {
        $form_action = 'mailing';
        $from_day = $this->getScheduleDefaultDateTime();
        $to_day   = $this->getScheduleDefaultDateTime();
        $to_day->modify('+5 day');

        $filterManager = new MailingFilterManager($this->container, array(
            'from_day' => $from_day,
            'to_day' => $to_day
        ));
        $form = $filterManager->createForm();
        $filteredData = array();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if (!$form->isValid()) {
                return $this->renderMailing($filteredData, $form, $form_action);
            }
            $filteredData = $form->getData();
        }

        return $this->renderMailing($filterManager->getFilteredData($filteredData), $form, $form_action);
    }

    /**
     * @Route("/mailing/send", name="mailing_send")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function sendMailAction(Request $request)
    {
        $mailing_form = $this->createForm(
            new MailingType(),
            new Mailing(
                $this->container,
                json_decode($this->get('request')->request->get('filtered_data')
            )
        ));

        $count = 0;

        if ($request->getMethod() == 'POST') {
            $mailing_form->bindRequest($request);

            if (!$mailing_form->isValid()) {
                die('error');
            }

            $count = $mailing_form->getData()->send();
        }

        return $this->render('W4HCalendarBundle:Default:sendMail.html.twig', array(
            'form_action' => 'mailing',
            'count' => $count
        ));
    }

    protected function getScheduleDefaultDateTime()
    {
        $year  = $this->container->getParameter('w4h_calendar.schedule_default_year');
        $month = $this->container->getParameter('w4h_calendar.schedule_default_month');
        $day   = $this->container->getParameter('w4h_calendar.schedule_default_day');

        return new \DateTime(sprintf('%d-%d-%d', $year, $month, $day));
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

        $response = $this->render('W4HCalendarBundle:Default:calendar.html.twig', array(
            'day'         => $filteredData['day'],
            'step'        => $step,
            'schedules'   => $calendar->getSchedules(),
            'calendar'    => $calendar->getCalendar($step, $filteredData, $display_empty_location),
            'form'        => $form->createView(),
            'form_action' => $form_action,
        ));

        $response->setPublic();
        $date = new \DateTime();
        $date->modify('+3600 seconds');
        $response->setExpires($date);

        return $response;
    }

    public function renderEventList($filteredData, $form, $form_action)
    {
        $calendar = $this->container->get('w4h_calendar.calendar');

        $response = $this->render('W4HCalendarBundle:Default:eventList.html.twig', array(
            'from'        => $filteredData['from'],
            'to'          => $filteredData['to'],
            'event_tasks' => $calendar->getEventTasks($filteredData),
            'form'        => $form->createView(),
            'form_action' => $form_action,
            'hidden_data' => $filteredData['hide_data']
        ));

        $response->setPublic();
        $date = new \DateTime();
        $date->modify('+3600 seconds');
        $response->setExpires($date);

        return $response;
    }

    public function renderEventListSchedule($filteredData, $form, $form_action)
    {
        $calendar = $this->container->get('w4h_calendar.calendar');

        $response = $this->render('W4HCalendarBundle:Default:eventListSchedule.html.twig', array(
            'schedule'    => $filteredData['schedule'],
            'event_tasks' => $calendar->getEventTasks($filteredData),
            'form'        => $form->createView(),
            'form_action' => $form_action,
            'hidden_data' => $filteredData['hide_data']
        ));

        $response->setPublic();
        $date = new \DateTime();
        $date->modify('+300 seconds');
        $response->setExpires($date);

        return $response;
    }

    public function renderMailing($filteredData, $form, $form_action)
    {
        $mailing_form = $this->createForm(
            new MailingType(),
            new Mailing(
                $this->container,
                $filteredData
            )
        );

        return $this->render('W4HCalendarBundle:Default:mailing.html.twig', array(
            'mailing_form'  => $mailing_form->createView(),
            'form'          => $form->createView(),
            'form_action'   => $form_action
        ));
    }
}

