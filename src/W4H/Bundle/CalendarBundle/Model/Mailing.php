<?php
namespace W4H\Bundle\CalendarBundle\Model;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class Mailing
{
    protected $to;
    protected $subject;
    protected $message;
    protected $em;
    protected $filteredData;

    public function __construct($em, $filteredData)
    {
        $this->setEm($em);
        $this->setFilteredData(json_encode($filteredData));

        $to = $this->getEm()->getRepository('W4HUserBundle:Person')
            ->findAllFiltered($filteredData);

        $this->setTo($to);
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getEm()
    {
        return $this->em;
    }

    public function setEm($em)
    {
        $this->em = $em;
    }

    public function getFilteredData()
    {
        return $this->filteredData;
    }

    public function setFilteredData($filteredData)
    {
        $this->filteredData = $filteredData;
    }
}
