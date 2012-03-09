<?php
namespace W4H\Bundle\PaperBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Entity(repositoryClass="W4H\Bundle\PaperBundle\Repository\PaperPresenterRepository")
 * @ORM\Table(
 *   name="paper_presenter",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="PAPER_PRESENTER_UNIQUE", columns={"person_id", "paper_id", "task_id"})}
 * )
 */
class PaperPresenter
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
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\PaperBundle\Entity\Paper")
     */
    protected $paper;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Task", inversedBy="presenters")
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
     * @param W4H\Bundle\PaperBundle\Entity\Paper $role
     */
    public function setRole(\W4H\Bundle\PaperBundle\Entity\Paper $role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return W4H\Bundle\PaperBundle\Entity\Paper 
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

    /**
     * Set paper
     *
     * @param W4H\Bundle\PaperBundle\Entity\Paper $paper
     */
    public function setPaper(\W4H\Bundle\PaperBundle\Entity\Paper $paper)
    {
        $this->paper = $paper;
    }

    /**
     * Get paper
     *
     * @return W4H\Bundle\PaperBundle\Entity\Paper 
     */
    public function getPaper()
    {
        return $this->paper;
    }
}