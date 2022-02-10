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
    protected $taxDailyColony;

    public function getTaxStartColony(): ?int
    {
        return $this->taxStartColony;
    }

    public function setTaxStartColony(int $taxStartColony): self
    {
        $this->taxStartColony = $taxStartColony;

        return $this;
    }

    public function getTaxDailyColony()
    {
        return $this->taxDailyColony;
    }

    public function setTaxDailyColony($taxDailyColony): self
    {
        $this->taxDailyColony = $taxDailyColony;

        return $this;
    }

    public function getOwner(): ?System
    {
        return $this->owner;
    }

    public function setOwner(?System $owner): self
    {
        $this->owner = $owner;

        return $this;
    } // tax by person per colony
}
