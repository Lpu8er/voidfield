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
    
    /**
     *
     * @var Star 
     * @ORM\ManyToOne(targetEntity="Star")
     * @ORM\JoinColumn(name="centerstar_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $centeredOn; // star
    /**
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $startable = false;
    
    public function getCenteredOn(): Star {
        return $this->centeredOn;
    }

    public function setCenteredOn(Star $centeredOn) {
        $this->centeredOn = $centeredOn;
        return $this;
    }

    public function getStartable() {
        return $this->startable;
    }

    public function setStartable($startable) {
        $this->startable = $startable;
        return $this;
    }


}
