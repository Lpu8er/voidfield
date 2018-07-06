<?php
namespace App\Entity;

/**
 * Description of Moon
 *
 * @author lpu8er
 */
class Moon extends Celestial {
    public function getCType() {
        return static::CTYPE_MOON;
    }
    
    public function colonisable(): bool {
        return true;
    }
}
