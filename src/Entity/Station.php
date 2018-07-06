<?php
namespace App\Entity;

/**
 * Description of Station
 *
 * @author lpu8er
 */
class Station extends Celestial {
    public function getCType() {
        return static::CTYPE_STATION;
    }
    
    public function colonisable(): bool {
        return true;
    }
}
