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
    
    /**
     *
     * @var Planet
     * @ORM\ManyToOne(targetEntity="Planet")
     * @ORM\JoinColumn(name="centerplanet_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $centeredOn;

    public function getCenteredOn(): ?Planet
    {
        return $this->centeredOn;
    }

    public function setCenteredOn(?Planet $centeredOn): self
    {
        $this->centeredOn = $centeredOn;

        return $this;
    } // planet
}
