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
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $name;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=20)
     */
    protected $ctype;
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;
    /**
     *
     * @var Celestial 
     * @ORM\ManyToOne(targetEntity="Celestial")
     * @ORM\JoinColumn(name="celestial_id", referencedColumnName="id")
     */
    protected $celestial;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $population; // total population
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hostiles; // hostiles, very unsatisfied
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $baddies; // unsatisfied
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $goodies; // satisfied persons
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $partisans; // very satisfied
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $dailyTax; // depends on population
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $earthToxicity; // local toxicity, can be moved by colony, will move and be moved by celestial
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $waterToxicity;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $airToxicity;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energy; // current stock
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $workers;// used
    /**
     *
     * @var Character 
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="leader_id", referencedColumnName="id", nullable=true)
     */
    protected $leader = null;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCtype() {
        return $this->ctype;
    }

    public function getOwner(): User {
        return $this->owner;
    }

    public function getCelestial(): Celestial {
        return $this->celestial;
    }

    public function getPopulation() {
        return $this->population;
    }

    public function getHostiles() {
        return $this->hostiles;
    }

    public function getBaddies() {
        return $this->baddies;
    }

    public function getGoodies() {
        return $this->goodies;
    }

    public function getPartisans() {
        return $this->partisans;
    }

    public function getDailyTax() {
        return $this->dailyTax;
    }

    public function getEarthToxicity() {
        return $this->earthToxicity;
    }

    public function getWaterToxicity() {
        return $this->waterToxicity;
    }

    public function getAirToxicity() {
        return $this->airToxicity;
    }

    public function getEnergy() {
        return $this->energy;
    }

    public function getWorkers() {
        return $this->workers;
    }

    public function getLeader() {
        return $this->leader;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setCtype($ctype) {
        $this->ctype = $ctype;
        return $this;
    }

    public function setOwner(User $owner) {
        $this->owner = $owner;
        return $this;
    }

    public function setCelestial(Celestial $celestial) {
        $this->celestial = $celestial;
        return $this;
    }

    public function setPopulation($population) {
        $this->population = $population;
        return $this;
    }

    public function setHostiles($hostiles) {
        $this->hostiles = $hostiles;
        return $this;
    }

    public function setBaddies($baddies) {
        $this->baddies = $baddies;
        return $this;
    }

    public function setGoodies($goodies) {
        $this->goodies = $goodies;
        return $this;
    }

    public function setPartisans($partisans) {
        $this->partisans = $partisans;
        return $this;
    }

    public function setDailyTax($dailyTax) {
        $this->dailyTax = $dailyTax;
        return $this;
    }

    public function setEarthToxicity($earthToxicity) {
        $this->earthToxicity = $earthToxicity;
        return $this;
    }

    public function setWaterToxicity($waterToxicity) {
        $this->waterToxicity = $waterToxicity;
        return $this;
    }

    public function setAirToxicity($airToxicity) {
        $this->airToxicity = $airToxicity;
        return $this;
    }

    public function setEnergy($energy) {
        $this->energy = $energy;
        return $this;
    }

    public function setWorkers($workers) {
        $this->workers = $workers;
        return $this;
    }

    public function setLeader(Character $leader = null) {
        $this->leader = $leader;
        return $this;
    }


}
