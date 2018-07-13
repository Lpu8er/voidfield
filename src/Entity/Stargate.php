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
    
    protected $targetGalaxy;
    protected $targetSystem;
    protected $targetX;
    protected $targetY;
    protected $targetZ;
    protected $targetDeviation;
    protected $jumpEnergyConsumption;
    protected $jumpCost;
}
