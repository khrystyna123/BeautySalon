<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="services")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicesRepository")
 */

class Services
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $service_name;

    /**
     * @ORM\ManyToMany(targetEntity="BeautySalon", inversedBy="services")
     * @ORM\JoinTable(name="salons_services",
     *      joinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="salon_id", referencedColumnName="id")}
     *      )
     */
    private $salons;

    public function __construct() {
        $this->salons = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getServiceName()
    {
        return $this->service_name;
    }

    public function setServiceName($service_name)
    {
        $this->service_name = $service_name;
    }

    public function getSalons()
    {
        return $this->salons;
    }

}