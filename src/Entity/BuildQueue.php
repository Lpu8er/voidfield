<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BuildQueue
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="buildqueues")
 */
class BuildQueue {
    /**
     *
     * @var Building 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Building")
     * @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     */
    protected $building;
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony", inversedBy="buildqueue")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $player;
    /**
     *
     * @var DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $startDate;
    /**
     *
     * @var DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $estimatedEndDate;
    /**
     * Last time queue was checked, will be used as `points -= (now()-lastQueueCheckDate)`
     * @var DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $lastQueueCheckDate;
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $points; // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 building built
    
    public function getBuilding(): Building {
        return $this->building;
    }

    public function getColony(): Colony {
        return $this->colony;
    }

    public function getPlayer(): User {
        return $this->player;
    }

    public function getStartDate(): DateTime {
        return $this->startDate;
    }

    public function getEstimatedEndDate(): DateTime {
        return $this->estimatedEndDate;
    }

    public function getLastQueueCheckDate(): DateTime {
        return $this->lastQueueCheckDate;
    }

    public function getPoints() {
        return $this->points;
    }

    public function setBuilding(Building $building) {
        $this->building = $building;
        return $this;
    }

    public function setColony(Colony $colony) {
        $this->colony = $colony;
        return $this;
    }

    public function setPlayer(User $player) {
        $this->player = $player;
        return $this;
    }

    public function setStartDate(DateTime $startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEstimatedEndDate(DateTime $estimatedEndDate) {
        $this->estimatedEndDate = $estimatedEndDate;
        return $this;
    }

    public function setLastQueueCheckDate(DateTime $lastQueueCheckDate) {
        $this->lastQueueCheckDate = $lastQueueCheckDate;
        return $this;
    }

    public function setPoints($points) {
        $this->points = $points;
        return $this;
    }


}
