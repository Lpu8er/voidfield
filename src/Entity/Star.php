<?php
namespace App\Entity;

/**
 * Description of Star
 *
 * @author lpu8er
 */
class Star extends Celestial {
    public function getCType(): string {
        return static::CTYPE_STAR;
    }
    
    public function colonisable(): bool {
        return false;
    }
    
    protected $energyStrength;
    protected $eol;
    protected $stype; // white, red...
}
