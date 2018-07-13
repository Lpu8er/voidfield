<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Planet
 *
 * @author lpu8er
 * @ORM\Entity
 */
class Planet extends Celestial {
    public function getCType(): string {
        return static::CTYPE_PLANET;
    }
    
    public function colonisable(): bool {
        return true;
    }
    
    protected $centeredOn; // star
}
