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
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Task")
     */
    protected $task;
}
