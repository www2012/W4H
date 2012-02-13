<?php
namespace W4H\Bundle\EventTaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\EventTaskBundle\Entity\Event;

class LoadEventData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $location = new Event();
        $location->setName('www2012 conference');
        $location->setWebsiteUrl('http://www2012.org');
        $manager->persist($location);

        $manager->flush();
    }
}
