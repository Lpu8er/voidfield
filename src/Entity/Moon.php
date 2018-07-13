<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Moon
 *
 * @author lpu8er
 * @ORM\Entity()
 */
class Moon extends Celestial {
    public function getCType(): string {
        return static::CTYPE_MOON;
    }
    
    public function colonisable(): bool {
        return true;
    }
    
    protected $centeredOn; // planet
}
