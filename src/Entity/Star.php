<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Star
 *
 * @author lpu8er
 * @ORM\Entity()
 */
class Star extends Celestial {
    public function getCType(): string {
        return static::CTYPE_STAR;
    }
    
    public function colonisable(): bool {
        return false;
    }
    
    protected $energyStrength; // decrease in space
    protected $eol;
    protected $stype; // white, red...
    protected $rgb; // rgb color of the star
}
