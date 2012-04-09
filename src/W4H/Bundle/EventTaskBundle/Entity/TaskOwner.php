<?php
namespace W4H\Bundle\EventTaskBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Entity(repositoryClass="W4H\Bundle\EventTaskBundle\Repository\TaskOwnerRepository")
 * @ORM\Table(
 *   name="task_owner",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="TASK_OWNER_UNIQUE", columns={"person_id", "role_id", "task_id"})}
 * )
 */
class TaskOwner
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\UserBundle\Entity\Person", inversedBy="owners")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\UserBundle\Entity\Role")
     */
    protected $role;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Task", inversedBy="owners")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     */
    protected $task;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set person
     *
     * @param W4H\Bundle\UserBundle\Entity\Person $person
     */
    public function setPerson(\W4H\Bundle\UserBundle\Entity\Person $person)
    {
        $this->person = $person;
    }

    /**
     * Get person
     *
     * @return W4H\Bundle\UserBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set role
     *
     * @param W4H\Bundle\UserBundle\Entity\Role $role
     */
    public function setRole(\W4H\Bundle\UserBundle\Entity\Role $role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return W4H\Bundle\UserBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set task
     *
     * @param W4H\Bundle\EventTaskBundle\Entity\Task $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }

    /**
     * Get task
     *
     * @return W4H\Bundle\EventTaskBundle\Entity\Task 
     */
    public function getTask()
    {
        return $this->task;
    }

    /* Export Getters */
    public function getPersonEmail() { return $this->getPerson()->getEmail(); }
    public function getPersonFirstName() { return $this->getPerson()->getFirstName(); }
    public function getPersonLastName() { return $this->getPerson()->getLastName(); }
    public function getPersonMobilePhone() { return $this->getPerson()->getMobilePhone(); }
    public function getPersonWebsiteUrl() { return $this->getPerson()->getWebsiteUrl(); }
    public function getPersonCountryIsoCode() { return $this->getPerson()->getCountryIsoCode(); }
    public function getRoleName() { return $this->getRole()->getName(); }
    public function getTaskId() { return $this->getTask()->getId(); }
    public function getTaskStartsAt() { return $this->getTask()->getStartsAt(); }
    public function getTaskName() { return $this->getTask()->getActivity()->getName(); }
}