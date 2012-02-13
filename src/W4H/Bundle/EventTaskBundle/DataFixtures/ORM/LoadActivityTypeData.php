<?php
namespace W4H\Bundle\EventTaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\EventTaskBundle\Entity\ActivityType;

class LoadActivityTypeData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $activity_type = new ActivityType();
        $activity_type->setName('Tutorial');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Workshop');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Panel');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Keynote');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Party');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('BarCamp');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('BOF');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Meeting');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Gathering');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Press Conference');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Conference Session');
        $manager->persist($activity_type);

        $activity_type = new ActivityType();
        $activity_type->setName('Transport');
        $manager->persist($activity_type);

        $manager->flush();
    }
}
