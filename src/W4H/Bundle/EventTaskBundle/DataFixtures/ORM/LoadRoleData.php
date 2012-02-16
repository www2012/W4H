<?php
namespace W4H\Bundle\EventTaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\EventTaskBundle\Entity\Role;

class LoadRoleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $role->setName('General Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Organization Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Volunteer');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Assistant Student');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Sponsoring Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Poster co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Demos co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Tutorials Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Speaker');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Security Head');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Project Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Copil Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Gala Responsible');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Opening Responsible');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Welcome Party Responsible');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Registration Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Metadata co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Proceedings co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Industry co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Registration Desk Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Registration Desk Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Welcome Desk Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Welcome Desk Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Journalist');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Press Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Communication Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Exhibition manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Technical Manager');
        $manager->persist($role);

        $manager->flush();
    }
}
