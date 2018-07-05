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
 * @ORM\DiscriminatorMap({"star" = "Star", "planet" = "Planet", "moon" = "Moon", "station" = "Station"})
 */
abstract class Celestial {
    protected $id;
    protected $name;
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
    protected $centeredOn;
    protected $ellipticCenterDistance;
    protected $waterToxicity;
    protected $earthToxicity;
    protected $airToxicity;
    protected $usableLandSurface;
    protected $usableWaterSurface;
    protected $usableAtmosphericSurface;
}
