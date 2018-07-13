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
    protected $name;
    protected $attackBase; // flat attack value
    protected $attackModifier; // modifier is only applied for calculated values of the same type
    protected $attackType; // no combination at the moment
    protected $defenseBase; // flat defense value : once all defenses are deplated, ship is down
    protected $defenseModifier; // modifier is only applied for calculated values of the same type
    protected $defenseType; // all defense values are only applied on this damage type
    protected $speedModifier; // may slow down or enhance speed (does not include mass)
    protected $speedBase; // base speed, prolly only on prop modules
    protected $special;
    protected $scanStrength;
    protected $mass;
    protected $size;
    protected $signatureBase;
    protected $signatureModifier;
    protected $slot;
    protected $slotUsage; // if that uses more than a slot, should not be used at first
    protected $energyConsumation; // flat value of energy consuming
    protected $energyBase; // base energy apport
    protected $energyModifier; // modifier energy apport
    protected $maxCargoMass;
    protected $maxCargoSize;
}
