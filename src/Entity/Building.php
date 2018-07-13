<?php
namespace App\Entity;

/**
 * Description of Building
 *
 * @author lpu8er
 */
class Building {
    const NEVER = 0;
    const RESTRICT_LAND = 1;
    const RESTRICT_WATER = 2;
    const RESTRICT_ATMOSPHERIC = 4;
    const RESTRICT_ORBITAL = 8;
    
    protected $id;
    protected $name;
    protected $restrictedTo;
    protected $buildCost; // money
    protected $replacing;
    protected $baseDuration;
    protected $points; // how many points (minutes) it needs
    protected $special;
    protected $energyConsumption;
    protected $buildWorkersNeeds; // how many needs to start the build
    protected $workers; // how many needed to stay up
    
}
