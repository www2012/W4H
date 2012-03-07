<?php
namespace W4H\Bundle\CalendarBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
            array('CIUEN', 'http://ciuen2012.org', '2012-04-16', '2012-04-18'),
            array('Common', '', '2012-04-16', '2012-04-20'),
            array('Global Media Connect', 'http://www.global-media-connect.com/www2012', '2012-04-19', '2012-04-19'),
            array('Salon du numérique', 'http://lyon-webcapital.org/salon', '2012-04-16', '2012-04-20'),
            array('W4A', 'http://www.w4a.info/2012', '2012-04-16', '2012-04-17'),
            array('WWW2012', 'http://www2012.org', '2012-04-16', '2012-04-20'),
        );

        $events = array();

        foreach($rows as $k => $row)
        {
          $events[$k] = new Event();
          $events[$k]->setName($row[0]);
          $events[$k]->setWebsiteUrl($row[1]);
          $events[$k]->setStartsOn(new \DateTime($row[2]));
          $events[$k]->setEndsOn(new \DateTime($row[3]));
          $manager->persist($events[$k]);
        }
        $manager->flush();

        /**************************************/
        // ActivityType
        /**************************************/
        $rows = array(
          'BarCamp', 'BOF', 'Conference Session', 'Demo Tracks', 'European Tracks',
          'Gathering', 'Industrial Tracks', 'Keynote', 'Meeting', 'Other', 'Panel',
          'Party', 'PhD Symp', 'Press Conference', 'Scientific Tracks', 'Transport',
          'Tutorial', 'Workshop'
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
        $rows = array();
        if (($handle = fopen("src/W4H/Bundle/CalendarBundle/DataFixtures/Data/activity.csv", "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 5000, ";", '"')) !== FALSE) {
            list($name, $description, $activity_type_key) = $data;

            if(!empty($name) && !empty($description) && !empty($activity_type_key)) {
              $rows[] = array(
                'name'              => $name,
                'description'       => $description,
                'activity_type_key' => $activity_type_key
              );
            } else {
              var_dump($data);
            }
          }

          fclose($handle);
        }

        $activities = array();
        foreach($rows as $k => $row)
        {
          $activities[$k] = new Activity();
          $activities[$k]->setName($row['name']);
          $activities[$k]->setDescription($row['description']);
          $activities[$k]->setActivityType($activity_types[$row['activity_type_key']]);
          $manager->persist($activities[$k]);
        }
        $manager->flush();

        /**************************************/
        // Roles
        /**************************************/
        $rows = array(
            'Assistant Student', 'Communication Chair', 'Copil Member', 'Demos co-chair',
            'Exhibition manager', 'Gala Responsible', 'General Co-Chair', 'Industry co-chair',
            'Journalist', 'Manager', 'Member', 'Metadata co-chair', 'Opening Responsible',
            'Organization Co-Chair', 'Poster co-chair', 'Press Chair', 'Proceedings co-chair',
            'Project Manager', 'Registration Desk Manager', 'Registration Desk Member', 'Registration Manager',
            'Security Head', 'Speaker', 'Sponsoring Manager', 'Technical Manager', 'Tutorials Co-Chair',
            'Volunteer', 'Welcome Desk Manager', 'Welcome Desk Member', 'Welcome Party Responsible'
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
        $rows = array();
        if (($handle = fopen("src/W4H/Bundle/CalendarBundle/DataFixtures/Data/location.csv", "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 5000, ";", '"')) !== FALSE) {
            list($name, $building, $level, $ClassRoomPlaces, $ConferenceRoomPlaces, $StandingRoomPlaces, $vp, $s, $i, $od, $accessibility, $lat, $lon) = $data;

            if(!empty($name) && !empty($building)) {
              $rows[] = array(
                'Name' => $name,
                'Building' => $building,
                'Level' => $level,
                'ClassRoomPlaces' => $ClassRoomPlaces,
                'ConferenceRoomPlaces' => $ConferenceRoomPlaces,
                'StandingRoomPlaces' => $StandingRoomPlaces,
                'VideoProjector' => $vp,
                'Sound' => $s,
                'Internet' => $i,
                'OtherDevices' => $od,
                'Accessibility' => $accessibility,
                'Latitude' => $lat,
                'Longitude' => $lon
              );
            } else {
              var_dump($data);
            }
          }

          fclose($handle);
        }

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
    }
}
