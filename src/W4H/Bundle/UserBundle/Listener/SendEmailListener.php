<?php

namespace W4H\Bundle\UserBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Acme\StoreBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendEmailListener
{
    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Person) {
            $message = \Swift_Message::newInstance()
                ->setSubject('www2012 - New password')
                ->setFrom('pierre@pierre.com')
                ->setTo('pierre.ferrolliet@gmail.com')
                ->setBody($twig->renderView('HelloBundle:Hello:email.txt.twig', array(
                    'user' => $entity
                )))
            ;
            $mailer->send($message);
        }
    }
}
