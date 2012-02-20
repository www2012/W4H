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
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\UserBundle\Entity\Person")
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
    public function setTask(\W4H\Bundle\EventTaskBundle\Entity\Task $task)
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
}