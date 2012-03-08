<?php
namespace W4H\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\UserBundle\Entity\Person;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
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

        $rows = array();
        if (($handle = fopen("src/W4H/Bundle/UserBundle/DataFixtures/Data/person.csv", "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 5000, ";", '"')) !== FALSE) {
            list($firstname, $lastname, $organisation, $mail, $country) = $data;

            if(!empty($firstname) && !empty($lastname) && !empty($mail)) {
              $username = strtolower(sprintf('%s.%s',trim($firstname), trim($lastname)));

              $rows[] = array(
                'username'      => $username,
                'firstname'     => trim($firstname),
                'lastname'      => trim($lastname),
                'organisation'  => trim($organisation),
                'email'         => trim($mail),
                'country'       => trim(strtoupper($country))
              );
            } else {
              var_dump($data);
            }
          }

          fclose($handle);
        }

        $persons = array();
        foreach($rows as $k => $row)
        {
          $persons[$k] = new Person();
          $persons[$k]->setUsername($row['username']);
          $persons[$k]->setEmail($row['email']);
          $persons[$k]->addRole(Person::ROLE_DEFAULT);
          $persons[$k]->setFirstName($row['firstname']);
          $persons[$k]->setLastName($row['lastname']);
          $persons[$k]->setOrganisation($row['organisation']);
          $persons[$k]->setCountryIsoCode($row['country']);
          $persons[$k]->setEnabled(true);
          $manager->persist($persons[$k]);
        }
        $manager->flush();
    }
}