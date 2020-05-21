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
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 0})
     */
    protected $attackBase = 0.; // flat attack value
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 1})
     */
    protected $attackModifier = 1.; // modifier is only applied for calculated values of the same type
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $attackType = null; // no combination at the moment
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 0})
     */
    protected $defenseBase = 0.; // flat defense value : once all defenses are deplated, ship is down
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 1})
     */
    protected $defenseModifier = 1.; // modifier is only applied for calculated values of the same type
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $defenseType = null; // all defense values are only applied on this damage type
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 1})
     */
    protected $speedModifier = 1.; // may slow down or enhance speed (does not include mass)
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 0})
     */
    protected $speedBase = 0.; // base speed, prolly only on prop modules
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $special = null;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $scanStrength = 0;
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
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 1})
     */
    protected $signatureModifier = 1.;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $slot;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    protected $slotUsage = 1; // if that uses more than a slot, should not be used at first
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energyConsumation; // flat value of energy consuming
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $energyBase = 0; // base energy apport
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 1})
     */
    protected $energyModifier = 1.; // modifier energy apport
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $maxCargoMass = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $maxCargoSize = 0;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): string {
        return $this->name;
    }

    public function getAttackBase(): float {
        return $this->attackBase;
    }

    public function getAttackModifier(): float {
        return $this->attackModifier;
    }

    public function getAttackType(): string {
        return $this->attackType;
    }

    public function getDefenseBase(): float {
        return $this->defenseBase;
    }

    public function getDefenseModifier(): float {
        return $this->defenseModifier;
    }

    public function getDefenseType(): string {
        return $this->defenseType;
    }

    public function getSpeedModifier(): float {
        return $this->speedModifier;
    }

    public function getSpeedBase(): float {
        return $this->speedBase;
    }

    public function getSpecial(): string {
        return $this->special;
    }

    public function getScanStrength(): int {
        return $this->scanStrength;
    }

    public function getMass(): float {
        return $this->mass;
    }

    public function getSize(): float {
        return $this->size;
    }

    public function getSignatureBase(): int {
        return $this->signatureBase;
    }

    public function getSignatureModifier(): float {
        return $this->signatureModifier;
    }

    public function getSlot(): string {
        return $this->slot;
    }

    public function getSlotUsage(): int {
        return $this->slotUsage;
    }

    public function getEnergyConsumation(): int {
        return $this->energyConsumation;
    }

    public function getEnergyBase(): int {
        return $this->energyBase;
    }

    public function getEnergyModifier(): float {
        return $this->energyModifier;
    }

    public function getMaxCargoMass(): int {
        return $this->maxCargoMass;
    }

    public function getMaxCargoSize(): int {
        return $this->maxCargoSize;
    }

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }

    public function setAttackBase(float $attackBase) {
        $this->attackBase = $attackBase;
        return $this;
    }

    public function setAttackModifier(float $attackModifier) {
        $this->attackModifier = $attackModifier;
        return $this;
    }

    public function setAttackType(?string $attackType = null) {
        $this->attackType = $attackType;
        return $this;
    }

    public function setDefenseBase(float $defenseBase) {
        $this->defenseBase = $defenseBase;
        return $this;
    }

    public function setDefenseModifier(float $defenseModifier) {
        $this->defenseModifier = $defenseModifier;
        return $this;
    }

    public function setDefenseType(?string $defenseType = null) {
        $this->defenseType = $defenseType;
        return $this;
    }

    public function setSpeedModifier(float $speedModifier) {
        $this->speedModifier = $speedModifier;
        return $this;
    }

    public function setSpeedBase(float $speedBase) {
        $this->speedBase = $speedBase;
        return $this;
    }

    public function setSpecial(?string $special = null) {
        $this->special = $special;
        return $this;
    }

    public function setScanStrength(int $scanStrength) {
        $this->scanStrength = $scanStrength;
        return $this;
    }

    public function setMass(float $mass) {
        $this->mass = $mass;
        return $this;
    }

    public function setSize(float $size) {
        $this->size = $size;
        return $this;
    }

    public function setSignatureBase(int $signatureBase) {
        $this->signatureBase = $signatureBase;
        return $this;
    }

    public function setSignatureModifier(float $signatureModifier) {
        $this->signatureModifier = $signatureModifier;
        return $this;
    }

    public function setSlot(string $slot) {
        $this->slot = $slot;
        return $this;
    }

    public function setSlotUsage(int $slotUsage) {
        $this->slotUsage = $slotUsage;
        return $this;
    }

    public function setEnergyConsumation(int $energyConsumation) {
        $this->energyConsumation = $energyConsumation;
        return $this;
    }

    public function setEnergyBase(int $energyBase) {
        $this->energyBase = $energyBase;
        return $this;
    }

    public function setEnergyModifier(float $energyModifier) {
        $this->energyModifier = $energyModifier;
        return $this;
    }

    public function setMaxCargoMass(int $maxCargoMass) {
        $this->maxCargoMass = $maxCargoMass;
        return $this;
    }

    public function setMaxCargoSize(int $maxCargoSize) {
        $this->maxCargoSize = $maxCargoSize;
        return $this;
    }
}
