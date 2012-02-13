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
        $role->setName('Accessibiliy co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('W3C co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Poster co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Demos co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Claroline co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('GMC co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('W4A Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Volunteer Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Tutorials Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Speaker');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Session Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('PC Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('PC track Co-Chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Security Head');
        $manager->persist($role);

        $role = new Role();
        $role->setName('www Copil Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('www Project Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('ciuen Project Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('LWWC Project Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('CCC Manager');
        $manager->persist($role);

        $role = new Role();
        $role->setName('LOC Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('ciuen Copil Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('LWWC Copil Member');
        $manager->persist($role);

        $role = new Role();
        $role->setName('OFF co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Off Event co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Exhibition co-chair');
        $manager->persist($role);

        $role = new Role();
        $role->setName('Gala Responsible');
        $manager->persist($role);

        $role = new Role();
        $role->setName('www Opening Responsible');
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
