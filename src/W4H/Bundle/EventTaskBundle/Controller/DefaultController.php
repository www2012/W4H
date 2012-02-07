<?php

namespace W4H\Bundle\EventTaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * Menu
     *
     * @Route("/{current}", name="menu")
     * @Template()
     */
    public function menuAction($current)
    {
        $menu = array();

        if($this->get('router')->getRouteCollection()->get('activity'))
        {
            $menu['activity'] = array(
                'label'   => 'Manage activities',
                'current' => $current == 'activity' ? 'current' : ''
            );
        }

        if($this->get('router')->getRouteCollection()->get('activity_type'))
        {
            $menu['activity_type'] = array(
                'label'   => 'Manage activities types',
                'current' => $current == 'activity_type' ? 'current' : ''
             );
        }

        return array('menu' => $menu);
    }
}
