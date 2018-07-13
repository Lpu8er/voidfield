<?php
namespace App\Entity;

/**
 * Description of Colony
 *
 * @author lpu8er
 */
class Colony {
    const CTYPE_EARTH = 'earth';
    const CTYPE_WATER = 'water';
    const CTYPE_AIR = 'air';
    const CTYPE_SPACE = 'space'; // only stations
    
    protected $id;
    protected $name;
    protected $ctype;
    protected $owner;
    protected $celestial;
    protected $population; // total population
    protected $dailyTax; // depends on population
    protected $earthToxicity; // local toxicity, can be moved by colony, will move and be moved by celestial
    protected $waterToxicity;
    protected $airToxicity;
    protected $energy;
    protected $workers;
    protected $leader;
}
