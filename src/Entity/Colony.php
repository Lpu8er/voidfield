<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Colony
 *
 * @author lpu8er
 * @ORM\Entity(repositoryClass="App\Repository\ColonyRepository")
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
    protected $population = 0; // total population
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hostiles = 0; // hostiles, very unsatisfied
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $baddies = 0; // unsatisfied
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $goodies = 0; // satisfied persons
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $partisans = 0; // very satisfied
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $dailyTax = 0.0; // depends on population
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $earthToxicity = 0.0; // local toxicity, can be moved by colony, will move and be moved by celestial
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $waterToxicity = 0.0;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $airToxicity = 0.0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energy = 0; // current stock
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $workers = 0;// used
    /**
     *
     * @var Character 
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="leader_id", referencedColumnName="id", nullable=true)
     */
    protected $leader = null;
    /**
     *
     * @var ColonyStock[]
     * @ORM\OneToMany(targetEntity="ColonyStock", mappedBy="colony")
     */
    protected $stocks;
    /**
     *
     * @var ColonyBuilding[]
     * @ORM\OneToMany(targetEntity="ColonyBuilding", mappedBy="colony")
     */
    protected $buildings;
    /**
     *
     * @var Fleet[]
     * @ORM\OneToMany(targetEntity="Fleet", mappedBy="colony")
     */
    protected $fleets;
    /**
     *
     * @var BuildQueue[]
     * @ORM\OneToMany(targetEntity="BuildQueue", mappedBy="colony")
     */
    protected $buildqueue;
    /**
     *
     * @var ResearchQueue[]
     * @ORM\OneToMany(targetEntity="ResearchQueue", mappedBy="colony")
     */
    protected $searchqueue;
    
    public function __construct() {
        $this->stocks = new ArrayCollection;
        $this->buildings = new ArrayCollection;
        $this->fleets = new ArrayCollection;
        $this->buildqueue = new ArrayCollection;
        $this->searchqueue = new ArrayCollection;
    }
    
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
    
    public function getSatisfaction() {
        return (0 < $this->population)? ((100 * ($this->goodies + $this->partisans)) / $this->population):0;
    }
    
    public function getInsatisfaction() {
        return (0 < $this->population)? ((100 * ($this->baddies + $this->hostiles)) / $this->population):0;
    }
    
    public function getNeutrals() {
        return floor(100 - ($this->getSatisfaction() + $this->getInsatisfaction()));
    }
    
    /**
     * 
     * @return ColonyStock[]
     */
    public function getStocks() {
        return $this->stocks;
    }

    /**
     * 
     * @return ColonyBuilding[]
     */
    public function getBuildings() {
        return $this->buildings;
    }

    /**
     * 
     * @return Fleet[]
     */
    public function getFleets() {
        return $this->fleets;
    }

    /**
     * 
     * @return BuilQueue[]
     */
    public function getBuildqueue() {
        return $this->buildqueue;
    }

    /**
     * 
     * @return ResearchQueue[]
     */
    public function getSearchqueue() {
        return $this->searchqueue;
    }

    public function setStocks($stocks) {
        $this->stocks = $stocks;
        return $this;
    }

    public function setBuildings($buildings) {
        $this->buildings = $buildings;
        return $this;
    }

    public function setFleets($fleets) {
        $this->fleets = $fleets;
        return $this;
    }

    public function setBuildqueue($buildqueue) {
        $this->buildqueue = $buildqueue;
        return $this;
    }

    public function setSearchqueue($searchqueue) {
        $this->searchqueue = $searchqueue;
        return $this;
    }

    public function addStock(ColonyStock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setColony($this);
        }

        return $this;
    }

    public function removeStock(ColonyStock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getColony() === $this) {
                $stock->setColony(null);
            }
        }

        return $this;
    }

    public function addBuilding(ColonyBuilding $building): self
    {
        if (!$this->buildings->contains($building)) {
            $this->buildings[] = $building;
            $building->setColony($this);
        }

        return $this;
    }

    public function removeBuilding(ColonyBuilding $building): self
    {
        if ($this->buildings->contains($building)) {
            $this->buildings->removeElement($building);
            // set the owning side to null (unless already changed)
            if ($building->getColony() === $this) {
                $building->setColony(null);
            }
        }

        return $this;
    }

    public function addFleet(Fleet $fleet): self
    {
        if (!$this->fleets->contains($fleet)) {
            $this->fleets[] = $fleet;
            $fleet->setColony($this);
        }

        return $this;
    }

    public function removeFleet(Fleet $fleet): self
    {
        if ($this->fleets->contains($fleet)) {
            $this->fleets->removeElement($fleet);
            // set the owning side to null (unless already changed)
            if ($fleet->getColony() === $this) {
                $fleet->setColony(null);
            }
        }

        return $this;
    }

    public function addBuildqueue(BuildQueue $buildqueue): self
    {
        if (!$this->buildqueue->contains($buildqueue)) {
            $this->buildqueue[] = $buildqueue;
            $buildqueue->setColony($this);
        }

        return $this;
    }

    public function removeBuildqueue(BuildQueue $buildqueue): self
    {
        if ($this->buildqueue->contains($buildqueue)) {
            $this->buildqueue->removeElement($buildqueue);
            // set the owning side to null (unless already changed)
            if ($buildqueue->getColony() === $this) {
                $buildqueue->setColony(null);
            }
        }

        return $this;
    }

    public function addSearchqueue(ResearchQueue $searchqueue): self
    {
        if (!$this->searchqueue->contains($searchqueue)) {
            $this->searchqueue[] = $searchqueue;
            $searchqueue->setColony($this);
        }

        return $this;
    }

    public function removeSearchqueue(ResearchQueue $searchqueue): self
    {
        if ($this->searchqueue->contains($searchqueue)) {
            $this->searchqueue->removeElement($searchqueue);
            // set the owning side to null (unless already changed)
            if ($searchqueue->getColony() === $this) {
                $searchqueue->setColony(null);
            }
        }

        return $this;
    }


}
