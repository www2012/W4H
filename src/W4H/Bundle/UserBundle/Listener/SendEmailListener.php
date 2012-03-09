<?php

namespace W4H\Bundle\UserBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use W4H\Bundle\UserBundle\Entity\Person;

class SendEmailListener
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Person) {
            $template = $this->container->get('twig')->loadTemplate('W4HUserBundle:Registration:email.txt.twig');
            $this->container->get('mailer');
            $message = \Swift_Message::newInstance()
                ->setSubject('www2012 - New password')
                ->setFrom($this->container->getParameter('swift_email_from'))
                ->setTo($entity->getEmail())
                ->setBody($template->render(array(
                    'user' => $entity
                )))
            ;
            $this->container->get('mailer')->send($message);
            $entity->cleanMailPassword();
        }
    }
}
