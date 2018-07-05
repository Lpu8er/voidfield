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
    
}
