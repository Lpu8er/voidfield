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
    
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $energyStrength; // decrease in space
    /**
     * 
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $eol = null;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $stype; // white, red...
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $rgb; // rgb color of the star
    
    public function getEnergyStrength() {
        return $this->energyStrength;
    }

    public function getEol(): \DateTime {
        return $this->eol;
    }

    public function getStype() {
        return $this->stype;
    }

    public function getRgb() {
        return $this->rgb;
    }

    public function setEnergyStrength($energyStrength) {
        $this->energyStrength = $energyStrength;
        return $this;
    }

    public function setEol(\DateTime $eol = null) {
        $this->eol = $eol;
        return $this;
    }

    public function setStype($stype) {
        $this->stype = $stype;
        return $this;
    }

    public function setRgb($rgb) {
        $this->rgb = $rgb;
        return $this;
    }


}
