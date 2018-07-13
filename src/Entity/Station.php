<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Station
 *
 * @author lpu8er
 * @ORM\Entity
 */
class Station extends Celestial {
    public function getCType(): string {
        return static::CTYPE_STATION;
    }
    
    public function colonisable(): bool {
        return true;
    }
    
    protected $owner; // a station is owned by someone
    protected $taxStartColony; // installation fees
    protected $taxDailyColony; // tax by person per colony
}
