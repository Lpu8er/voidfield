<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Building
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="buildings")
 */
class Building {
    const NEVER = 0;
    const RESTRICT_LAND = 1;
    const RESTRICT_WATER = 2;
    const RESTRICT_ATMOSPHERIC = 4;
    const RESTRICT_ORBITAL = 8;
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $name;
    protected $description;
    protected $restrictedTo;
    protected $buildCost; // money
    protected $replacing;
    protected $baseDuration;
    protected $points; // how many points (minutes) it needs
    protected $special;
    protected $energyConsumption;
    protected $buildWorkersNeeds; // how many needs to start the build
    protected $workers; // how many needed to stay up
    protected $earthToxicity; // moving index for earth
    protected $waterToxicity; // moving index for earth
    protected $airToxicity; // moving index for earth
    
}
