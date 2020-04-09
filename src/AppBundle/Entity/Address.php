<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AddressRepository")
 */

class Address
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BeautySalon", inversedBy="address")
     * @ORM\JoinColumn(name="salon_id", referencedColumnName="id")
     */
    private $salon;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $street;

    /**
     * @ORM\Column(type="integer", length=5)
     */
    private $house_number;

    public function getId()
    {
        return $this->id;
    }

    public function getSalon()
    {
        return $this->salon;
    }

    public function setSalon($salon)
    {
        $this->salon = $salon;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getHouseNumber()
    {
        return $this->house_number;
    }

    public function setHouseNumber($house_number)
    {
        $this->house_number = $house_number;
    }


}