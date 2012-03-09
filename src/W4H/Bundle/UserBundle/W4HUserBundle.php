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
}

