<?php
namespace App\Entity;

/**
 * Description of Research
 *
 * @author lpu8er
 */
class Research {
    protected $id;
    protected $name;
    protected $replacing; // if that replace a previous one (previous level, usually)
    protected $baseDuration;
    protected $searchCost;
    protected $points; // how many points (minutes) it needs
}
