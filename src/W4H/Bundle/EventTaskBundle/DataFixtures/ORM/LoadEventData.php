<?php
namespace W4H\Bundle\EventTaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\EventTaskBundle\Entity\Event;

class LoadEventData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event = new Event();
        $event->setName('www2012 conference');
        $event->setWebsiteUrl('http://www2012.org');
        $manager->persist($event);

        $event = new Event();
        $event->setName('W4A');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('CIUEN');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('WebScience');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('W3C');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www WorkShops');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Tutorials');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Developpers Track');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Industry Track');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Posters Track');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Demonstration Track');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www European Track');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Panels Track');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Plenary Keyynotes');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('www Plenary Panel');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('Global Media Connect');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $event = new Event();
        $event->setName('Claroline');
        $event->setWebsiteUrl('');
        $manager->persist($event);

        $manager->flush();
    }
}
