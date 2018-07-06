<?php
namespace App\Entity;

/**
 * Description of ColonyBuilding
 *
 * @author lpu8er
 */
class ColonyBuilding {
    protected $building;
    protected $colony;
    protected $running; // percent of func, allow energy and resources saving
    protected $integrity; // percent of integrity, lower the func
}
