<?php
namespace W4H\Bundle\CalendarBundle\Model;

use Symfony\Component\Locale\Locale;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class Mailing
{
    protected $container;
    protected $to;
    protected $subject;
    protected $message;
    protected $filteredData;

    public function __construct($container, $filteredData)
    {
        $this->setContainer($container);
        $this->setFilteredData(json_encode($filteredData));

        $persons = $this->getEm()->getRepository('W4HUserBundle:Person')
            ->findAllFiltered($filteredData);

        $to = array();
        foreach($persons as $person)
          $to[$person->getId()] = $person;

        $this->setTo($to);
    }

    public function send()
    {
        $persons = $this->getEm()->getRepository('W4HUserBundle:Person')->findById($this->getTo());

        $count = 0;
        foreach($persons as $person)
        {
            $message = \Swift_Message::newInstance()
                ->setSubject($this->getSubject())
                ->setFrom($this->getContainer()->getParameter('swift_email_from'))
                ->setTo($person->getEmail())
                ->setBody($this->renderMessage($this->getMessage(), $person))
            ;

            $this->getContainer()->get('mailer')->send($message);
            $count++;
        }

        return $count;
    }

    public function renderMessage($message, $person)
    {
        $countries = Locale::getDisplayCountries(
            \Locale::getDefault()
        );

        $country = $person->getCountryIsoCode() ? $countries[$person->getCountryIsoCode()] : 'Unknown';

        $merge_tags = array(
            '%first_name%'  => $person->getFirstName(),
            '%last_name%'   => $person->getLastName(),
            '%country%'     => $country
        );

        return str_replace(array_keys($merge_tags), array_values($merge_tags), $message);
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

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getFilteredData()
    {
        return $this->filteredData;
    }

    public function setFilteredData($filteredData)
    {
        $this->filteredData = $filteredData;
    }

    public function getEm()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }
}

