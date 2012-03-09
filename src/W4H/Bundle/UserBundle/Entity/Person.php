<?php

namespace W4H\Bundle\UserBundle\Entity;

#use FOS\UserBundle\Entity\User as BaseUser;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Table(name="fos_user_user")
 * @ORM\Entity(repositoryClass="W4H\Bundle\UserBundle\Repository\UserRepository")
 */
class Person extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $organisation;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $service;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $other_mail;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    protected $mobile_phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $website_url;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $freeset;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $socials_account;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    protected $country_iso_code;

    protected $mail_password;

    public function __toString()
    {
        return sprintf('%s %s <%s>',
          $this->getLastName(),
          $this->getFirstName(),
          $this->getEmail()
        );
    }

    /**
     * @return void
     */
    public function prePersist()
    {
        parent::prePersist();

        // Generate a default password if this field is empty
        if(!isset($this->plainPassword))
            $this->setPlainPassword(self::generatePassword());
    }

    public static function generatePassword()
    {
        $chars = ":-+&#!abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = '';

        for($i = 0; $i < 8; $i++) {
            $random_index = mt_rand(0,strlen($chars)-1);
            $random_char = substr($chars, $random_index, 1);
            $password = $password.$random_char;
        }

        return $password;
    }

    /**
     * Save temporary email plain password in order to send it to user
     */
    public function eraseCredentials()
    {
        $this->mail_password = $this->getPlainPassword();
        parent::eraseCredentials();
    }

    /**
     * Remove the email plain password
     */
    public function cleanMailPassword()
    {
        $this->mail_password = null;
    }

    /**
     * Get plain password for email sending
     */
    public function getMailPassword()
    {
        return $this->mail_password;
    }

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
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set organisation
     *
     * @param string $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * Get organisation
     *
     * @return string 
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Set service
     *
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * Get service
     *
     * @return string 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set other_mail
     *
     * @param string $otherMail
     */
    public function setOtherMail($otherMail)
    {
        $this->other_mail = $otherMail;
    }

    /**
     * Get other_mail
     *
     * @return string 
     */
    public function getOtherMail()
    {
        return $this->other_mail;
    }

    /**
     * Set mobile_phone
     *
     * @param string $mobilePhone
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobile_phone = $mobilePhone;
    }

    /**
     * Get mobile_phone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobile_phone;
    }

    /**
     * Set website_url
     *
     * @param string $websiteUrl
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->website_url = $websiteUrl;
    }

    /**
     * Get website_url
     *
     * @return string 
     */
    public function getWebsiteUrl()
    {
        return $this->website_url;
    }

    /**
     * Set freeset
     *
     * @param string $freeset
     */
    public function setFreeset($freeset)
    {
        $this->freeset = $freeset;
    }

    /**
     * Get freeset
     *
     * @return string 
     */
    public function getFreeset()
    {
        return $this->freeset;
    }

    /**
     * Set socials_account
     *
     * @param string $socialsAccount
     */
    public function setSocialsAccount($socialsAccount)
    {
        $this->socials_account = $socialsAccount;
    }

    /**
     * Get socials_account
     *
     * @return string 
     */
    public function getSocialsAccount()
    {
        return $this->socials_account;
    }

    /**
     * Set country_iso_code
     *
     * @param string $countryIsoCode
     */
    public function setCountryIsoCode($countryIsoCode)
    {
        $this->country_iso_code = $countryIsoCode;
    }

    /**
     * Get country_iso_code
     *
     * @return string 
     */
    public function getCountryIsoCode()
    {
        return $this->country_iso_code;
    }
}
