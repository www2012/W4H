<?php
namespace W4H\Bundle\LocationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\LocationBundle\Entity\Location;

class LoadLocationData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $location = new Location();
        $location->setName('Salle Bellecour 1');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Bellecour 2');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Bellecour 3');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Foyers Forum 4, 5 & 6');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Forum 4');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Forum 5');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Forum 6');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Tête d\'Or 1');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Tête d\'Or 2');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Tête d\'Or 1+2');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salon Tête d\'Organization');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Gratte-Ciel 1');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Gratte-Ciel 2');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Gratte-Ciel 3');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salle Gratte-Ciel 1+2+3');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Foyer Gratte-Ciel Rhône');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Foyer Gratte-Ciel Parc');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Foyer Gratte-Ciel Prestige');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Salon Prestige Gratte-Ciel');
        $manager->persist($location);

        $location = new Location();
        $location->setName('Grand Salon Prestige Gratte-Ciel');
        $manager->persist($location);

        $manager->flush();
    }
}
