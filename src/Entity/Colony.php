<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Colony
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="colonies")
 */
class Colony {
    const CTYPE_EARTH = 'earth';
    const CTYPE_WATER = 'water';
    const CTYPE_AIR = 'air';
    const CTYPE_SPACE = 'space'; // only stations
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
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
