<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use W4H\Bundle\CalendarBundle\Model\Calendar;
use W4H\Bundle\CalendarBundle\Form\CalendarFilterType;
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
        $response = $this->forward('W4HCalendarBundle:Default:displayDate', array(
            'year'  => 2012,
            'month' => str_pad(04, 2, 0, STR_PAD_LEFT),
            'day'   => str_pad(16, 2, 0, STR_PAD_LEFT)
        ));

        return $response;
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
     * @Route("/{year}/{month}/{day}", name="calendar_show")
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
            'day'       => array(
                'year'  => $year,
                'month' => str_pad($month, 2, 0, STR_PAD_LEFT),
                'day'   => str_pad($day, 2, 0, STR_PAD_LEFT)
            ),
            'form'      => $form->createView(),
            'schedules' => $calendar->getSchedules(),
            'calendar'  => $calendar->getCalendar($datetime, $step),
            'step'      => $step
        );
    }

    /**
     * @Route("/{year}/{month}/{day}/filter", name="calendar_filter")
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
            'day'       => array(
                'year'  => $year,
                'month' => str_pad($month, 2, 0, STR_PAD_LEFT),
                'day'   => str_pad($day, 2, 0, STR_PAD_LEFT)
            ),
            'form'      => $form->createView(),
            'schedules' => $calendar->getSchedules(),
            'calendar'  => $calendar->getCalendar($datetime, $step, $filters),
            'step'      => $step
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
     * @Route("/move-task/{task_id}", name="calendar_move_task")
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
}

