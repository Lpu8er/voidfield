<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Travel
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="travels")
 */
class Travel {
    /**
     *
     * @var Fleet 
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Fleet")
     * @ORM\JoinColumn(name="fleet_id", referencedColumnName="id")
     */
    protected $fleet; // id
    /**
     *
     * @var System 
     * @ORM\OneToOne(targetEntity="System")
     * @ORM\JoinColumn(name="start_system_id", referencedColumnName="id")
     */
    protected $startSystem;
    /**
     *
     * @var Celestial 
     * @ORM\OneToOne(targetEntity="Celestial")
     * @ORM\JoinColumn(name="start_celestial_id", referencedColumnName="id", nullable=true)
     */
    protected $startCelestial = null;
    /**
     *
     * @var Colony 
     * @ORM\OneToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="start_colony_id", referencedColumnName="id", nullable=true)
     */
    protected $startColony = null;
    /**
     *
     * @var System 
     * @ORM\OneToOne(targetEntity="System")
     * @ORM\JoinColumn(name="end_system_id", referencedColumnName="id")
     */
    protected $endSystem;
    /**
     *
     * @var Celestial 
     * @ORM\OneToOne(targetEntity="Celestial")
     * @ORM\JoinColumn(name="end_celestial_id", referencedColumnName="id", nullable=true)
     */
    protected $endCelestial;
    /**
     *
     * @var Colony 
     * @ORM\OneToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="end_colony_id", referencedColumnName="id", nullable=true)
     */
    protected $endColony;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startDate;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $estimatedEndDate;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $estimatedDuration;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $currentDuration;

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEstimatedEndDate(): ?\DateTimeInterface
    {
        return $this->estimatedEndDate;
    }

    public function setEstimatedEndDate(?\DateTimeInterface $estimatedEndDate): self
    {
        $this->estimatedEndDate = $estimatedEndDate;

        return $this;
    }

    public function getEstimatedDuration(): ?int
    {
        return $this->estimatedDuration;
    }

    public function setEstimatedDuration(int $estimatedDuration): self
    {
        $this->estimatedDuration = $estimatedDuration;

        return $this;
    }

    public function getCurrentDuration(): ?int
    {
        return $this->currentDuration;
    }

    public function setCurrentDuration(int $currentDuration): self
    {
        $this->currentDuration = $currentDuration;

        return $this;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function setFleet(?Fleet $fleet): self
    {
        $this->fleet = $fleet;

        return $this;
    }

    public function getStartSystem(): ?System
    {
        return $this->startSystem;
    }

    public function setStartSystem(?System $startSystem): self
    {
        $this->startSystem = $startSystem;

        return $this;
    }

    public function getStartCelestial(): ?Celestial
    {
        return $this->startCelestial;
    }

    public function setStartCelestial(?Celestial $startCelestial): self
    {
        $this->startCelestial = $startCelestial;

        return $this;
    }

    public function getStartColony(): ?Colony
    {
        return $this->startColony;
    }

    public function setStartColony(?Colony $startColony): self
    {
        $this->startColony = $startColony;

        return $this;
    }

    public function getEndSystem(): ?System
    {
        return $this->endSystem;
    }

    public function setEndSystem(?System $endSystem): self
    {
        $this->endSystem = $endSystem;

        return $this;
    }

    public function getEndCelestial(): ?Celestial
    {
        return $this->endCelestial;
    }

    public function setEndCelestial(?Celestial $endCelestial): self
    {
        $this->endCelestial = $endCelestial;

        return $this;
    }

    public function getEndColony(): ?Colony
    {
        return $this->endColony;
    }

    public function setEndColony(?Colony $endColony): self
    {
        $this->endColony = $endColony;

        return $this;
    }
}
