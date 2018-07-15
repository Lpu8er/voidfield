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
}
