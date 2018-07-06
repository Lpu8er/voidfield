<?php
namespace App\Entity;

/**
 * Description of Stargate
 *
 * @author lpu8er
 */
class Stargate extends Celestial {
    public function getCType() {
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
