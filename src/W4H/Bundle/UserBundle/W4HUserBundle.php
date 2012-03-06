<?php

namespace W4H\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use W4H\Bundle\UserBundle\Listener\SendEmailListener;
use Doctrine\ORM\Events;

class W4HUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

    public function boot()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $evm = $em->getEventManager();

        $evm->addEventListener(array(Events::prePersist), new SendEmailListener($this->container));
    }
}

