<?php
namespace W4H\Bundle\CalendarBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\EventTaskBundle\Entity\Event;
use W4H\Bundle\EventTaskBundle\Entity\ActivityType;
use W4H\Bundle\EventTaskBundle\Entity\Activity;
use W4H\Bundle\EventTaskBundle\Entity\Task;
use W4H\Bundle\EventTaskBundle\Entity\TaskOwner;
use W4H\Bundle\UserBundle\Entity\Role;
use W4H\Bundle\LocationBundle\Entity\Location;
use W4H\Bundle\UserBundle\Entity\Person;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**************************************/
        // Event
        /**************************************/
        $rows = array(
            array('www2012 conference', 'http://www2012.org'),
            array('W4A', ''),
            array('CIUEN', ''),
            array('WebScience', ''),
            array('W3C', 'http://w3c.org'),
            array('www WorkShops', ''),
            array('www Tutorials', ''),
            array('www Developpers Track', ''),
            array('www Industry Track', ''),
            array('www Posters Track', ''),
            array('www Demonstration Track', ''),
            array('www European Track', ''),
            array('www Panels Track', ''),
            array('www Plenary Keynotes', ''),
            array('www Plenary Panel', ''),
            array('Global Media Connect', ''),
        );

        $events = array();

        foreach($rows as $k => $row)
        {
          $events[$k] = new Event();
          $events[$k]->setName($row[0]);
          $events[$k]->setWebsiteUrl($row[1]);
          $manager->persist($events[$k]);
        }

        $manager->flush();

        /**************************************/
        // ActivityType
        /**************************************/
        $rows = array(
          'Tutorial', 'Workshop', 'Panel', 'Keynote', 'Party', 'BarCamp', 'BOF',
          'Meeting', 'Gathering', 'Press Conference', 'Conference Session',
          'Transport'
        );

        $activity_types = array();

        foreach($rows as $k => $row)
        {
          $activity_types[$k] = new ActivityType();
          $activity_types[$k]->setName($row);
          $manager->persist($activity_types[$k]);
        }

        $manager->flush();

        /**************************************/
        // Activity
        /**************************************/
        $rows = array(
          array('World Digital Solidarity', 'Web everywhere… how to reduce digital divide'),
          array('Sociological evolution due to web usage', 'How web changes our world'),
          array('Web Accessibility initiative', 'Web for all… how to allow people with disabilities to use the web'),
          array('Web for learning', 'How web can impact pedagogy'),
          array('Massively Multiplayer Online Games', 'Evolution of digital games'),
          array('Video on the web', 'From Lumière brothers to the movies of future'),
          array('Industrial track', 'How web can impact the industry'),
        );

        $activities = array();

        foreach($rows as $k => $row)
        {
          $activities[$k] = new Activity();
          $activities[$k]->setName($row[0]);
          $activities[$k]->setDescription($row[1]);
          $activities[$k]->setActivityType($activity_types[$k]);
          $manager->persist($activities[$k]);
        }

        $manager->flush();

        /**************************************/
        // Roles
        /**************************************/
        $rows = array(
            'General Co-Chair', 'Organization Co-Chair', 'Volunteer',
            'Assistant Student', 'Sponsoring Manager', 'Poster co-chair',
            'Demos co-chair', 'Tutorials Co-Chair', 'Speaker', 'Security Head',
            'Member', 'Project Manager', 'Manager', 'Copil Member', 'Gala Responsible',
            'Opening Responsible', 'Welcome Party Responsible', 'Registration Manager',
            'Metadata co-chair', 'Proceedings co-chair', 'Industry co-chair',
            'Registration Desk Manager', 'Registration Desk Member', 'Welcome Desk Manager',
            'Welcome Desk Member', 'Journalist', 'Press Chair', 'Communication Chair',
            'Exhibition manager', 'Technical Manager'
        );

        $roles = array();

        foreach($rows as $k => $row)
        {
          $roles[$k] = new Role();
          $roles[$k]->setName($row);
          $manager->persist($roles[$k]);
        }

        $manager->flush();

        /**************************************/
        // Location
        /**************************************/
        $rows = array(
          array(
            'Name' => 'Salle Bellecour 1',
            'Building' => 'Nouveau',
            'Level' => 'Accueil Bellecour',
            'ClassRoomPlaces' => 56,
            'ConferenceRoomPlaces' => 125,
            'StandingRoomPlaces' => 130,
            'VideoProjector' => true,
            'Sound' => false,
            'Internet' => false,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Bellecour 2',
            'Building' => 'Nouveau',
            'Level' => 'Accueil Bellecour',
            'ClassRoomPlaces' => 84,
            'ConferenceRoomPlaces' => 154,
            'StandingRoomPlaces' => 130,
            'VideoProjector' => true,
            'Sound' => false,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Bellecour 3',
            'Building' => 'Nouveau',
            'Level' => 'Accueil Bellecour',
            'ClassRoomPlaces' => 68,
            'ConferenceRoomPlaces' => 105,
            'StandingRoomPlaces' => 120,
            'VideoProjector' => true,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Foyers Forum 4, 5 & 6',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Forum',
            'ClassRoomPlaces' => 0,
            'ConferenceRoomPlaces' => 0,
            'StandingRoomPlaces' => 1300,
            'VideoProjector' => false,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Forum 4',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Forum',
            'ClassRoomPlaces' => 768,
            'ConferenceRoomPlaces' => 1297,
            'StandingRoomPlaces' => 1150,
            'VideoProjector' => true,
            'Sound' => false,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Forum 5',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Forum',
            'ClassRoomPlaces' => 632,
            'ConferenceRoomPlaces' => 1082,
            'StandingRoomPlaces' => 1000,
            'VideoProjector' => true,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Forum 6',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Forum',
            'ClassRoomPlaces' => 768,
            'ConferenceRoomPlaces' => 1190,
            'StandingRoomPlaces' => 1150,
            'VideoProjector' => true,
            'Sound' => false,
            'Internet' => false,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Tête d\'Or 1',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Tête d\'Or',
            'ClassRoomPlaces' => 46,
            'ConferenceRoomPlaces' => 99,
            'StandingRoomPlaces' => 80,
            'VideoProjector' => false,
            'Sound' => false,
            'Internet' => false,
            'OtherDevices' => 'test',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Tête d\'Or 2',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Tête d\'Or',
            'ClassRoomPlaces' => 48,
            'ConferenceRoomPlaces' => 99,
            'StandingRoomPlaces' => 90,
            'VideoProjector' => false,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Tête d\'Or 1+2',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Tête d\'Or',
            'ClassRoomPlaces' => 116,
            'ConferenceRoomPlaces' => 192,
            'StandingRoomPlaces' => 170,
            'VideoProjector' => true,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salon Tête d\'Organization',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Tête d\'Or',
            'ClassRoomPlaces' => 88,
            'ConferenceRoomPlaces' => 180,
            'StandingRoomPlaces' => 150,
            'VideoProjector' => true,
            'Sound' => true,
            'Internet' => false,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Gratte-Ciel 1',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 38,
            'ConferenceRoomPlaces' => 100,
            'StandingRoomPlaces' => 80,
            'VideoProjector' => false,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Gratte-Ciel 2',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 54,
            'ConferenceRoomPlaces' => 115,
            'StandingRoomPlaces' => 90,
            'VideoProjector' => false,
            'Sound' => true,
            'Internet' => false,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Gratte-Ciel 3',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 42,
            'ConferenceRoomPlaces' => 84,
            'StandingRoomPlaces' => 80,
            'VideoProjector' => false,
            'Sound' => false,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salle Gratte-Ciel 1+2+3',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 180,
            'ConferenceRoomPlaces' => 330,
            'StandingRoomPlaces' => 240,
            'VideoProjector' => true,
            'Sound' => false,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Foyer Gratte-Ciel Rhône',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 0,
            'ConferenceRoomPlaces' => 50,
            'StandingRoomPlaces' => 250,
            'VideoProjector' => true,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Foyer Gratte-Ciel Parc',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 0,
            'ConferenceRoomPlaces' => 50,
            'StandingRoomPlaces' => 250,
            'VideoProjector' => false,
            'Sound' => true,
            'Internet' => false,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Foyer Gratte-Ciel Prestige',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 0,
            'ConferenceRoomPlaces' => 0,
            'StandingRoomPlaces' => 0,
            'VideoProjector' => true,
            'Sound' => false,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Salon Prestige Gratte-Ciel',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 88,
            'ConferenceRoomPlaces' => 168,
            'StandingRoomPlaces' => 150,
            'VideoProjector' => true,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
          array(
            'Name' => 'Grand Salon Prestige Gratte-Ciel',
            'Building' => 'Nouveau',
            'Level' => 'Niveau Gratte-Ciel',
            'ClassRoomPlaces' => 154,
            'ConferenceRoomPlaces' => 288,
            'StandingRoomPlaces' => 200,
            'VideoProjector' => true,
            'Sound' => true,
            'Internet' => true,
            'OtherDevices' => '',
            'Accessibility' => 2,
            'Latitude' => '',
            'Longitude' => '',
          ),
        );

        $locations = array();

        foreach($rows as $k => $row)
        {
          $locations[$k] = new Location();
          $locations[$k]->setName($row['Name']);
          $locations[$k]->setBuilding($row['Building']);
          $locations[$k]->setLevel($row['Level']);
          $locations[$k]->setClassRoomPlaces($row['ClassRoomPlaces']);
          $locations[$k]->setConferenceRoomPlaces($row['ConferenceRoomPlaces']);
          $locations[$k]->setStandingRoomPlaces($row['StandingRoomPlaces']);
          $locations[$k]->setVideoProjector($row['VideoProjector']);
          $locations[$k]->setSound($row['Sound']);
          $locations[$k]->setInternet($row['Internet']);
          $locations[$k]->setOtherDevices($row['OtherDevices']);
          $locations[$k]->setAccessibility($row['Accessibility']);
          $locations[$k]->setLatitude($row['Latitude']);
          $locations[$k]->setLongitude($row['Longitude']);
          $manager->persist($locations[$k]);
        }

        $manager->flush();

        /**************************************/
        // Person
        /**************************************/
        $admin = new Person();
        $admin->setUsername('admin');
        $admin->setEmail('admin@w3c.og');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true);
        $admin->addRole(Person::ROLE_SUPER_ADMIN);
        $admin->setFirstName('admin');
        $admin->setLastName('ADMIN');
        $admin->setOrganisation('admin');
        $admin->setCountryIsoCode('US');
        $manager->persist($admin);

        $person_a = new Person();
        $person_a->setUsername('tim');
        $person_a->setEmail('tim.bernerslee@w3c.og');
        $person_a->setPlainPassword('123456');
        $person_a->addRole(Person::ROLE_DEFAULT);
        $person_a->setFirstName('Tim');
        $person_a->setLastName('BERNERS LEE');
        $person_a->setOrganisation('W3C');
        $person_a->setCountryIsoCode('GB');
        $manager->persist($person_a);

        $person_b = new Person();
        $person_b->setUsername('alain');
        $person_b->setEmail('alin.mille@univ-lyon1.fr');
        $person_b->setPlainPassword('123456');
        $person_b->addRole(Person::ROLE_DEFAULT);
        $person_b->setFirstName('Alain');
        $person_b->setLastName('MILLE');
        $person_b->setOrganisation('Université LYON 1');
        $person_b->setCountryIsoCode('FR');
        $manager->persist($person_b);

        $person_c = new Person();
        $person_c->setUsername('bernard');
        $person_c->setEmail('bernard.stiegler@mail.fr');
        $person_c->setPlainPassword('123456');
        $person_c->addRole(Person::ROLE_DEFAULT);
        $person_c->setFirstName('Bernard');
        $person_c->setLastName('STIEGLER');
        $person_c->setOrganisation('Organisation');
        $person_c->setCountryIsoCode('FR');
        $manager->persist($person_c);

        /**************************************/
        // Task
        /**************************************/
        $task_a = new Task();
        $task_a->setStartsAt(new \DateTime('2012-04-16 8:30'));
        $task_a->setEndsAt(new \DateTime('2012-04-16 10:00'));
        $task_a->setLocation($locations[1]);
        $task_a->setActivity($activities[1]);
        $task_a->setEvent($events[1]);
        $manager->persist($task_a);

        $task_b = new Task();
        $task_b->setStartsAt(new \DateTime('2012-04-16 11:00'));
        $task_b->setEndsAt(new \DateTime('2012-04-16 14:00'));
        $task_b->setLocation($locations[0]);
        $task_b->setActivity($activities[2]);
        $task_b->setEvent($events[3]);
        $manager->persist($task_b);

        $task_c = new Task();
        $task_c->setStartsAt(new \DateTime('2012-04-16 15:00'));
        $task_c->setEndsAt(new \DateTime('2012-04-16 16:45'));
        $task_c->setLocation($locations[1]);
        $task_c->setActivity($activities[0]);
        $task_c->setEvent($events[5]);
        $manager->persist($task_c);

        $task_d = new Task();
        $task_d->setStartsAt(new \DateTime('2012-04-16 8:45'));
        $task_d->setEndsAt(new \DateTime('2012-04-16 11:00'));
        $task_d->setLocation($locations[3]);
        $task_d->setActivity($activities[0]);
        $task_d->setEvent($events[2]);
        $manager->persist($task_d);

        $task_e = new Task();
        $task_e->setStartsAt(new \DateTime('2012-04-16 16:00'));
        $task_e->setEndsAt(new \DateTime('2012-04-16 20:30'));
        $task_e->setLocation($locations[4]);
        $task_e->setActivity($activities[5]);
        $task_e->setEvent($events[6]);
        $manager->persist($task_e);

        /**************************************/
        // TaskOwner
        /**************************************/
        $to = new TaskOwner();
        $to->setPerson($person_a);
        $to->setRole($roles[8]);
        $to->setTask($task_a);
        $manager->persist($to);


        $manager->flush();
    }
}
