<?php

namespace W4H\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class W4HUserBundle extends Bundle
{
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}

