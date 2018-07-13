<?php
namespace App\Entity;

/**
 * Description of Planet
 *
 * @author lpu8er
 */
class Planet extends Celestial {
    public function getCType(): string {
        return static::CTYPE_PLANET;
    }
    
    public function colonisable(): bool {
        return true;
    }
}
