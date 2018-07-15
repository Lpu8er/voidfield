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
    
    /**
     * 
     * @var System
     * @ORM\ManyToOne(targetEntity="System")
     * @ORM\JoinColumn(name="system_id", referencedColumnName="id")
     */
    protected $owner; // a station is owned by someone
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $taxStartColony; // installation fees
    /**
     * 
     * @var int
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $taxDailyColony; // tax by person per colony
}
