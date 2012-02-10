<?php

namespace W4H\Bundle\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/admin/", name="admin_calendar")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * Menu
     *
     * @Route("/admin/menu/{current}", name="admin_menu")
     * @Template()
     */
    public function menuAction($current)
    {
        $menu = array(
          'task'          => array('label' => 'Task', 'current' => false),
          'fos_user_profile_show' => array('label' => 'Person', 'current' => false),
          'activity'      => array('label' => 'Activity', 'current' => false),
          'role'          => array('label' => 'Role', 'current' => false),
          'location'      => array('label' => 'Location', 'current' => false),
          'activitytype'  => array('label' => 'Activity Type', 'current' => false),
          'event'         => array('label' => 'Event', 'current' => false)
        );

        /*
        if($this->get('router')->getRouteCollection()->get('metastaz_template'))
        {
            $menu['metastaz_template'] = array(
                'label' => 'Gestion des templates',
                'current' => $current == 'template' ? 'current' : ''
            );
        }

        if($this->get('router')->getRouteCollection()->get('metastaz_product'))
        {
           $menu['metastaz_product'] = array(
                'label' => 'Gestion des produits',
                'current' => $current == 'product' ? 'current' : ''
            );
        }
        */

        return array('menu' => $menu);
    }
}
