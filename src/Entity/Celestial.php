<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Celestial
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="celestials")
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
    /**
     * 
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;
    protected $system;
    protected $galaxy;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $x;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $y;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $z;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $radius;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $spin;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $maxTemp;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $minTemp;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $medWindSpeed;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $derivWindSpeed;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $waterPercent;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $waterViability;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $ellipticCenterDistance;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $waterToxicity;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $earthToxicity;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $airToxicity;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $usableLandSurface; // usable size / nb of colonies of this type => usable surface for a player, first one best one
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $usableWaterSurface;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $usableAtmosphericSurface;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $gravity;
    
    abstract public function getCType(): string;
    abstract public function colonisable(): bool;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getSystem() {
        return $this->system;
    }

    public function getGalaxy() {
        return $this->galaxy;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    public function getZ() {
        return $this->z;
    }

    public function getRadius() {
        return $this->radius;
    }

    public function getSpin() {
        return $this->spin;
    }

    public function getMaxTemp() {
        return $this->maxTemp;
    }

    public function getMinTemp() {
        return $this->minTemp;
    }

    public function getMedWindSpeed() {
        return $this->medWindSpeed;
    }

    public function getDerivWindSpeed() {
        return $this->derivWindSpeed;
    }

    public function getWaterPercent() {
        return $this->waterPercent;
    }

    public function getWaterViability() {
        return $this->waterViability;
    }

    public function getEllipticCenterDistance() {
        return $this->ellipticCenterDistance;
    }

    public function getWaterToxicity() {
        return $this->waterToxicity;
    }

    public function getEarthToxicity() {
        return $this->earthToxicity;
    }

    public function getAirToxicity() {
        return $this->airToxicity;
    }

    public function getUsableLandSurface() {
        return $this->usableLandSurface;
    }

    public function getUsableWaterSurface() {
        return $this->usableWaterSurface;
    }

    public function getUsableAtmosphericSurface() {
        return $this->usableAtmosphericSurface;
    }

    public function getGravity() {
        return $this->gravity;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setSystem($system) {
        $this->system = $system;
        return $this;
    }

    public function setGalaxy($galaxy) {
        $this->galaxy = $galaxy;
        return $this;
    }

    public function setX($x) {
        $this->x = $x;
        return $this;
    }

    public function setY($y) {
        $this->y = $y;
        return $this;
    }

    public function setZ($z) {
        $this->z = $z;
        return $this;
    }

    public function setRadius($radius) {
        $this->radius = $radius;
        return $this;
    }

    public function setSpin($spin) {
        $this->spin = $spin;
        return $this;
    }

    public function setMaxTemp($maxTemp) {
        $this->maxTemp = $maxTemp;
        return $this;
    }

    public function setMinTemp($minTemp) {
        $this->minTemp = $minTemp;
        return $this;
    }

    public function setMedWindSpeed($medWindSpeed) {
        $this->medWindSpeed = $medWindSpeed;
        return $this;
    }

    public function setDerivWindSpeed($derivWindSpeed) {
        $this->derivWindSpeed = $derivWindSpeed;
        return $this;
    }

    public function setWaterPercent($waterPercent) {
        $this->waterPercent = $waterPercent;
        return $this;
    }

    public function setWaterViability($waterViability) {
        $this->waterViability = $waterViability;
        return $this;
    }

    public function setEllipticCenterDistance($ellipticCenterDistance) {
        $this->ellipticCenterDistance = $ellipticCenterDistance;
        return $this;
    }

    public function setWaterToxicity($waterToxicity) {
        $this->waterToxicity = $waterToxicity;
        return $this;
    }

    public function setEarthToxicity($earthToxicity) {
        $this->earthToxicity = $earthToxicity;
        return $this;
    }

    public function setAirToxicity($airToxicity) {
        $this->airToxicity = $airToxicity;
        return $this;
    }

    public function setUsableLandSurface($usableLandSurface) {
        $this->usableLandSurface = $usableLandSurface;
        return $this;
    }

    public function setUsableWaterSurface($usableWaterSurface) {
        $this->usableWaterSurface = $usableWaterSurface;
        return $this;
    }

    public function setUsableAtmosphericSurface($usableAtmosphericSurface) {
        $this->usableAtmosphericSurface = $usableAtmosphericSurface;
        return $this;
    }

    public function setGravity($gravity) {
        $this->gravity = $gravity;
        return $this;
    }


}
