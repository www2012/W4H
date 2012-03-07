<?php

namespace W4H\Bundle\UserBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use W4H\Bundle\UserBundle\Entity\Person;

class SendEmailListener
{
    protected $twig;
    protected $mailer;
    public function __construct($twig, $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Person) {
            $message = \Swift_Message::newInstance()
                ->setSubject('www2012 - New password')
                ->setFrom('pierre@pierre.com')
                ->setTo('pierre.ferrolliet@gmail.com')
                ->setBody($this->twig->renderView('W4HUserBundle:Registration:email.txt.twig', array(
                    'user' => $entity
                )))
            ;
            $this->mailer->send($message);
        }
    }
}
