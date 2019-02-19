<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Module
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="modules")
 */
class Module {
    const DAMAGETYPE_THERMAL = 'thermal';
    const DAMAGETYPE_KINETIC = 'kinetic';
    const DAMAGETYPE_EMP = 'emp';
    const DAMAGETYPE_EXPLOSIVE = 'explosive';
    const DAMAGETYPE_CORROSIVE = 'corrosive';
    const DAMAGETYPE_EXOTIC = 'exotic';
    
    const SPECIAL_RADAR = 'radar'; // check current forces, incoming and outgoing fleets, base colony informations
    const SPECIAL_JAMMER = 'jammer'; // same as radar but reverse effects (hide details and provide randomly false info)
    const SPECIAL_TRACKER = 'tracker'; // allows pin-pointing for some things : fleets ? colonies ? resources ? artefacts ?
    const SPECIAL_PROBER = 'prober'; // same as tracker (we'll split roles, prolly tracker for artefacts / colonies / resources, probers for fleets)
    
    const SLOT_EXTERNAL_EQUIPMENT = 'exteqp'; // external usable equipment : deployable, turrets
    const SLOT_EXTERNAL_UTILITY = 'extutil'; // external utility : defense, detectors, cargoholds
    const SLOT_INTERNAL_ENGINE = 'engine'; // internal engine : energy boost, thruster boosts
    const SLOT_INTERNAL_EQUIPMENT = 'inteqp'; // internal usable equipment (prolly won't be used at first)
    const SLOT_INTERNAL_UTILITY = 'intutil'; // internal utility : defense, attack boosts, cargoholds...
    const SLOT_PROPULSION = 'prop'; // propulsion - self explicit
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $attackBase; // flat attack value
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $attackModifier; // modifier is only applied for calculated values of the same type
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $attackType; // no combination at the moment
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $defenseBase; // flat defense value : once all defenses are deplated, ship is down
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $defenseModifier; // modifier is only applied for calculated values of the same type
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $defenseType; // all defense values are only applied on this damage type
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $speedModifier; // may slow down or enhance speed (does not include mass)
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $speedBase; // base speed, prolly only on prop modules
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $special;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $scanStrength;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $mass;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $size;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $signatureBase;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $signatureModifier;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $slot;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $slotUsage; // if that uses more than a slot, should not be used at first
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energyConsumation; // flat value of energy consuming
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energyBase; // base energy apport
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $energyModifier; // modifier energy apport
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $maxCargoMass;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $maxCargoSize;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAttackBase()
    {
        return $this->attackBase;
    }

    public function setAttackBase($attackBase): self
    {
        $this->attackBase = $attackBase;

        return $this;
    }

    public function getAttackModifier()
    {
        return $this->attackModifier;
    }

    public function setAttackModifier($attackModifier): self
    {
        $this->attackModifier = $attackModifier;

        return $this;
    }

    public function getAttackType(): ?string
    {
        return $this->attackType;
    }

    public function setAttackType(string $attackType): self
    {
        $this->attackType = $attackType;

        return $this;
    }

    public function getDefenseBase()
    {
        return $this->defenseBase;
    }

    public function setDefenseBase($defenseBase): self
    {
        $this->defenseBase = $defenseBase;

        return $this;
    }

    public function getDefenseModifier()
    {
        return $this->defenseModifier;
    }

    public function setDefenseModifier($defenseModifier): self
    {
        $this->defenseModifier = $defenseModifier;

        return $this;
    }

    public function getDefenseType(): ?string
    {
        return $this->defenseType;
    }

    public function setDefenseType(string $defenseType): self
    {
        $this->defenseType = $defenseType;

        return $this;
    }

    public function getSpeedModifier()
    {
        return $this->speedModifier;
    }

    public function setSpeedModifier($speedModifier): self
    {
        $this->speedModifier = $speedModifier;

        return $this;
    }

    public function getSpeedBase()
    {
        return $this->speedBase;
    }

    public function setSpeedBase($speedBase): self
    {
        $this->speedBase = $speedBase;

        return $this;
    }

    public function getSpecial(): ?string
    {
        return $this->special;
    }

    public function setSpecial(string $special): self
    {
        $this->special = $special;

        return $this;
    }

    public function getScanStrength(): ?int
    {
        return $this->scanStrength;
    }

    public function setScanStrength(int $scanStrength): self
    {
        $this->scanStrength = $scanStrength;

        return $this;
    }

    public function getMass()
    {
        return $this->mass;
    }

    public function setMass($mass): self
    {
        $this->mass = $mass;

        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSignatureBase(): ?int
    {
        return $this->signatureBase;
    }

    public function setSignatureBase(int $signatureBase): self
    {
        $this->signatureBase = $signatureBase;

        return $this;
    }

    public function getSignatureModifier()
    {
        return $this->signatureModifier;
    }

    public function setSignatureModifier($signatureModifier): self
    {
        $this->signatureModifier = $signatureModifier;

        return $this;
    }

    public function getSlot(): ?string
    {
        return $this->slot;
    }

    public function setSlot(string $slot): self
    {
        $this->slot = $slot;

        return $this;
    }

    public function getSlotUsage(): ?int
    {
        return $this->slotUsage;
    }

    public function setSlotUsage(int $slotUsage): self
    {
        $this->slotUsage = $slotUsage;

        return $this;
    }

    public function getEnergyConsumation(): ?int
    {
        return $this->energyConsumation;
    }

    public function setEnergyConsumation(int $energyConsumation): self
    {
        $this->energyConsumation = $energyConsumation;

        return $this;
    }

    public function getEnergyBase(): ?int
    {
        return $this->energyBase;
    }

    public function setEnergyBase(int $energyBase): self
    {
        $this->energyBase = $energyBase;

        return $this;
    }

    public function getEnergyModifier()
    {
        return $this->energyModifier;
    }

    public function setEnergyModifier($energyModifier): self
    {
        $this->energyModifier = $energyModifier;

        return $this;
    }

    public function getMaxCargoMass(): ?int
    {
        return $this->maxCargoMass;
    }

    public function setMaxCargoMass(int $maxCargoMass): self
    {
        $this->maxCargoMass = $maxCargoMass;

        return $this;
    }

    public function getMaxCargoSize(): ?int
    {
        return $this->maxCargoSize;
    }

    public function setMaxCargoSize(int $maxCargoSize): self
    {
        $this->maxCargoSize = $maxCargoSize;

        return $this;
    }
}
