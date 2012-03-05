<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use W4H\Bundle\CalendarBundle\Model\Calendar;
use W4H\Bundle\CalendarBundle\Form\CalendarFilterType;
use W4H\Bundle\CalendarBundle\Form\UserCalendarFilterType;
use W4H\Bundle\CalendarBundle\Form\CalendarMoveTaskType;
use W4H\Bundle\EventTaskBundle\Form\TaskType;

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
    public function indexAction()
    {
        $filters     = $this->getIndexFilters();
        $form        = $this->createForm(new UserCalendarFilterType());
        $form_action = "calendar_filters";

        return $this->renderCalendar(2012, 04, 16, $form, $form_action, $filters);
    }

    /**
     * @Route("/calendar/{year}/{month}/{day}/filters", name="calendar_filters")
     */
    public function indexFilterAction($year, $month, $day)
    {
        $filters     = $this->getIndexFilters();
        $form        = $this->createForm(new UserCalendarFilterType());
        $form_action = "calendar_filters";

        return $this->renderCalendarFilters($year, $month, $day, $form, $form_action, $filters);
    }

    /**
     * Return all filters matching a collection of Role
     */
    public function getIndexFilters()
    {
        $em    = $this->getDoctrine()->getEntityManager();
        $roles = $em->getRepository('W4HUserBundle:Role')->findByName(array(
            "Journalist",
            "Speaker"
        ));

        return array('role' => $roles);
    }

    /**
     * @Route("/calendar/me", name="calendar_user")
     */
    public function myCalendarAction()
    {
        $filters     = $this->getMyCalendarFilters(); 
        $form        = $this->createForm(new UserCalendarFilterType());
        $form_action = "calendar_user_filters";

        return $this->renderCalendar(2012, 04, 16, $form, $form_action, $filters);
    }

    /**
     * @Route("/calendar/me/{year}/{month}/{day}/filters", name="calendar_user_filters")
     */
    public function myCalendarFilterAction($year, $month, $day)
    {
        $filters  = $this->getMyCalendarFilters(); 
        $form     = $this->createForm(new UserCalendarFilterType());
        $form_action = "calendar_user_filters";

        return $this->renderCalendarFilters($year, $month, $day, $form, $form_action, $filters);
    }

    /**
     * Return all filters matching a logged user
     */
    public function getMyCalendarFilters()
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $user   = $this->container->get('security.context')->getToken()->getUser();
        $person = $em->getRepository('W4HUserBundle:Person')->find($user->getId());

        return array('person' => array($person));
    }

    /**
     * @Route("/calendar/all", name="calendar_admin")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function adminCalendarAction()
    {
        $form        = $this->createForm(new CalendarFilterType());
        $form_action = "calendar_admin_filters";

        return $this->renderCalendar(2012, 04, 16, $form, $form_action);
    }

    /**
     * @Route("/calendar/all/{year}/{month}/{day}/filters", name="calendar_admin_filters")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function adminCalendarFilterAction($year, $month, $day)
    {
        $form        = $this->createForm(new CalendarFilterType());
        $form_action = "calendar_admin_filters";

        return $this->renderCalendarFilters($year, $month, $day, $form, $form_action);
    }

    /**
     * @Route("/renderCSS/{step}", name="calendar_render_css")
     * @Template("W4HCalendarBundle:Default:calendar.css.twig")
     */
    public function renderCSSAction($step, $columns = 62)
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
     * @Route("/event-list", name="event_list")
     * @Template("W4HCalendarBundle:Default:eventList.html.twig")
     */
    public function eventListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $event_tasks = $em->getRepository('W4HEventTaskBundle:Task')->findAllSortByEvent();

        return array('event_tasks' => $event_tasks);
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

    public function renderCalendar($year, $month, $day, $form, $form_action, $filters = null)
    {
        $filters  = is_null($filters) ? array() : $filters;
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
            'form'        => $form->createView(),
            'schedules'   => $calendar->getSchedules(),
            'calendar'    => $calendar->getCalendar($datetime, $step, $filters),
            'step'        => $step,
            'form_action' => $form_action
        ));
    }

    public function renderCalendarFilters($year, $month, $day, $form, $form_action, $filters = null)
    {
        $filters = is_null($filters) ? array() : $filters;
        $request = $this->getRequest();
        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            if ($form->isValid())
            {
                $filters = array_merge($filters, $form->getData());
            }
        }

        return $this->renderCalendar($year, $month, $day, $form, $form_action, $filters);
    }
}

