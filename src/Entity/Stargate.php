<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Stargate
 *
 * @author lpu8er
 * @ORM\Entity
 */
class Stargate extends Celestial {
    public function getCType(): string {
        return static::CTYPE_STARGATE;
    }
    
    public function colonisable(): bool {
        return false;
    }
    
    /**
     * 
     * @var Galaxy
     * @ORM\ManyToOne(targetEntity="Galaxy")
     * @ORM\JoinColumn(name="galaxy_id", referencedColumnName="id")
     */
    protected $targetGalaxy;
    /**
     * 
     * @var System
     * @ORM\ManyToOne(targetEntity="System")
     * @ORM\JoinColumn(name="system_id", referencedColumnName="id")
     */
    protected $targetSystem;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $targetX;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $targetY;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $targetZ;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $targetDeviation;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $jumpEnergyConsumption;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $jumpCost;

    public function getTargetX(): ?int
    {
        return $this->targetX;
    }

    public function setTargetX(int $targetX): self
    {
        $this->targetX = $targetX;

        return $this;
    }

    public function getTargetY(): ?int
    {
        return $this->targetY;
    }

    public function setTargetY(int $targetY): self
    {
        $this->targetY = $targetY;

        return $this;
    }

    public function getTargetZ(): ?int
    {
        return $this->targetZ;
    }

    public function setTargetZ(int $targetZ): self
    {
        $this->targetZ = $targetZ;

        return $this;
    }

    public function getTargetDeviation()
    {
        return $this->targetDeviation;
    }

    public function setTargetDeviation($targetDeviation): self
    {
        $this->targetDeviation = $targetDeviation;

        return $this;
    }

    public function getJumpEnergyConsumption(): ?int
    {
        return $this->jumpEnergyConsumption;
    }

    public function setJumpEnergyConsumption(int $jumpEnergyConsumption): self
    {
        $this->jumpEnergyConsumption = $jumpEnergyConsumption;

        return $this;
    }

    public function getJumpCost(): ?int
    {
        return $this->jumpCost;
    }

    public function setJumpCost(int $jumpCost): self
    {
        $this->jumpCost = $jumpCost;

        return $this;
    }

    public function getTargetGalaxy(): ?Galaxy
    {
        return $this->targetGalaxy;
    }

    public function setTargetGalaxy(?Galaxy $targetGalaxy): self
    {
        $this->targetGalaxy = $targetGalaxy;

        return $this;
    }

    public function getTargetSystem(): ?System
    {
        return $this->targetSystem;
    }

    public function setTargetSystem(?System $targetSystem): self
    {
        $this->targetSystem = $targetSystem;

        return $this;
    }
}
