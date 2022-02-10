<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ResearchQueue
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researchqueue")
 */
class ResearchQueue {
    /**
     *
     * @var Research 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="research_id", referencedColumnName="id")
     */
    protected $research;
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony", inversedBy="searchqueue")
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
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $startDate;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $estimatedEndDate;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $lastQueueCheckDate;
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $points;

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEstimatedEndDate(): ?\DateTimeInterface
    {
        return $this->estimatedEndDate;
    }

    public function setEstimatedEndDate(\DateTimeInterface $estimatedEndDate): self
    {
        $this->estimatedEndDate = $estimatedEndDate;

        return $this;
    }

    public function getLastQueueCheckDate(): ?\DateTimeInterface
    {
        return $this->lastQueueCheckDate;
    }

    public function setLastQueueCheckDate(\DateTimeInterface $lastQueueCheckDate): self
    {
        $this->lastQueueCheckDate = $lastQueueCheckDate;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getResearch(): ?Research
    {
        return $this->research;
    }

    public function setResearch(?Research $research): self
    {
        $this->research = $research;

        return $this;
    }

    public function getColony(): ?Colony
    {
        return $this->colony;
    }

    public function setColony(?Colony $colony): self
    {
        $this->colony = $colony;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    } // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 technology won
}
