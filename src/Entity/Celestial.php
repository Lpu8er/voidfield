<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Celestial
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="ctype", type="string")
 * @ORM\DiscriminatorMap({"star" = "Star", "planet" = "Planet", "moon" = "Moon", "station" = "Station", "stargate" = "Stargate"})
 */
abstract class Celestial {
    const CTYPE_STAR = 'star';
    const CTYPE_PLANET = 'planet';
    const CTYPE_MOON = 'moon';
    const CTYPE_STATION = 'station';
    const CTYPE_STARGATE = 'stargate';
    
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
    protected $description;
    protected $system;
    protected $galaxy;
    protected $x;
    protected $y;
    protected $z;
    protected $radius;
    protected $spin;
    protected $maxTemp;
    protected $minTemp;
    protected $medWindSpeed;
    protected $derivWindSpeed;
    protected $waterPercent;
    protected $waterViability;
    protected $centeredOn; // nah, remove it
    protected $ellipticCenterDistance;
    protected $waterToxicity;
    protected $earthToxicity;
    protected $airToxicity;
    protected $usableLandSurface; // usable size / nb of colonies of this type => usable surface for a player, first one best one
    protected $usableWaterSurface;
    protected $usableAtmosphericSurface;
    protected $gravity;
    
    abstract public function getCType(): string;
    abstract public function colonisable(): bool;
}
