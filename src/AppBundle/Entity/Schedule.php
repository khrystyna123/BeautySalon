<?php

namespace AppBundle\Entity;

use AppBundle\Enums\OpeningStatus;
use AppBundle\Enums\Days;
use ClassesWithParents\D;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="schedule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $day;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    /**
     * @ORM\Column(type="time")
     */
    private $start_time;

    /**
     * @ORM\Column(type="time")
     */
    private $end_time;

    /**
     * @ORM\ManyToMany(targetEntity="BeautySalon", inversedBy="schedule")
     * @ORM\JoinTable(name="salon_schedule",
     *      joinColumns={@ORM\JoinColumn(name="schedule_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="salon_id", referencedColumnName="id")}
     *      )
     */
    private $salon;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
    {
        if (!in_array($day, array(Days::Monday, Days::Tuesday, Days::Wednesday, Days::Thursday,
                        Days::Friday, Days::Saturday, Days::Sunday))) {
            throw new \InvalidArgumentException("Invalid day");
        }
        $this->day = $day;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if (!in_array($status, array(OpeningStatus::Closed, OpeningStatus::Opened))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }

    public function getStartTime()
    {
        return $this->start_time;
    }

    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    public function getEndTime()
    {
        return $this->end_time;
    }

    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
    }

    public function getSalon()
    {
        return $this->salon;
    }

    public function setSalon($salon)
    {
        $this->salon = $salon;
    }

}