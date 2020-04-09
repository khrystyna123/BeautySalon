<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Table(name="app_salons")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BeautySalonRepository")
 */

class BeautySalon
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="salons")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Services", mappedBy="salons")
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="salon")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $insta_username;

    /**
     * @ORM\OneToOne(targetEntity="SalonInformation", mappedBy="salon")
     */
    private $info;

    /**
     * @ORM\ManyToMany(targetEntity="Schedule", mappedBy="salon")
     */
    private $schedule;

    public function __construct() {
        $this->address = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function getInstaUsername()
    {
        return $this->insta_username;
    }

    public function setInstaUsername($insta_username)
    {
        $this->insta_username = $insta_username;
    }

    public function getServices()
    {
        return $this->services;
    }

    public function setServices($services)
    {
        $this->services = $services;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }

    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }

}
