<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="salon_info")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalonInfoRepository")
 */

class SalonInformation
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="BeautySalon", inversedBy="info")
     * @ORM\JoinColumn(name="salon_id", referencedColumnName="id")
     */
    private $salon;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $info;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSalon()
    {
        return $this->salon;
    }

    public function setSalon($salon)
    {
        $this->salon = $salon;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

}