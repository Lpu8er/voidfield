<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Building
 *
 * @author lpu8er
 * @ORM\Entity(repositoryClass="App\Repository\BuildingRepository")
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
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $name;
    /**
     *
     * @var string 
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $restrictedTo;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $buildCost; // money
    /**
     *
     * @var Building 
     * @ORM\ManyToOne(targetEntity="Building")
     * @ORM\JoinColumn(name="replacing_id", referencedColumnName="id", nullable=true)
     */
    protected $replacing = null;
    /**
     *
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $baseDuration;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $points; // how many points (minutes) it needs
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $special = '';
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $energyConsumption = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $buildWorkersNeeds = 0; // how many needs to start the build
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $workers = 0; // how many needed to stay up
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $earthToxicity = 0.; // moving index for earth
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $waterToxicity = 0.; // moving index for earth
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $airToxicity = 0.; // moving index for earth
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $energyStock = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $energyProd = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $workersStock = 0;
    /**
     *
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $assaultType;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $assaultValue = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $hitpoints;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $size;
    /**
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $alwaysVisible = true;
    
    /**
     *
     * @var BuildRecipe[]
     * @ORM\OneToMany(targetEntity="BuildRecipe", mappedBy="building")
     */
    protected $recipe;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getRestrictedTo() {
        return $this->restrictedTo;
    }

    public function getBuildCost() {
        return $this->buildCost;
    }

    public function getReplacing(): Building {
        return $this->replacing;
    }

    public function getBaseDuration() {
        return $this->baseDuration;
    }

    public function getPoints() {
        return $this->points;
    }

    public function getSpecial() {
        return $this->special;
    }

    public function getEnergyConsumption() {
        return $this->energyConsumption;
    }

    public function getBuildWorkersNeeds() {
        return $this->buildWorkersNeeds;
    }

    public function getWorkers() {
        return $this->workers;
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

    public function getEnergyStock() {
        return $this->energyStock;
    }

    public function getEnergyProd() {
        return $this->energyProd;
    }

    public function getWorkersStock() {
        return $this->workersStock;
    }

    public function getAssaultType() {
        return $this->assaultType;
    }

    public function getAssaultValue() {
        return $this->assaultValue;
    }

    public function getHitpoints() {
        return $this->hitpoints;
    }

    public function getSize() {
        return $this->size;
    }

    public function getAlwaysVisible() {
        return $this->alwaysVisible;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setRestrictedTo($restrictedTo) {
        $this->restrictedTo = $restrictedTo;
        return $this;
    }

    public function setBuildCost($buildCost) {
        $this->buildCost = $buildCost;
        return $this;
    }

    public function setReplacing(Building $replacing) {
        $this->replacing = $replacing;
        return $this;
    }

    public function setBaseDuration($baseDuration) {
        $this->baseDuration = $baseDuration;
        return $this;
    }

    public function setPoints($points) {
        $this->points = $points;
        return $this;
    }

    public function setSpecial($special) {
        $this->special = $special;
        return $this;
    }

    public function setEnergyConsumption($energyConsumption) {
        $this->energyConsumption = $energyConsumption;
        return $this;
    }

    public function setBuildWorkersNeeds($buildWorkersNeeds) {
        $this->buildWorkersNeeds = $buildWorkersNeeds;
        return $this;
    }

    public function setWorkers($workers) {
        $this->workers = $workers;
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

    public function setEnergyStock($energyStock) {
        $this->energyStock = $energyStock;
        return $this;
    }

    public function setEnergyProd($energyProd) {
        $this->energyProd = $energyProd;
        return $this;
    }

    public function setWorkersStock($workersStock) {
        $this->workersStock = $workersStock;
        return $this;
    }

    public function setAssaultType($assaultType) {
        $this->assaultType = $assaultType;
        return $this;
    }

    public function setAssaultValue($assaultValue) {
        $this->assaultValue = $assaultValue;
        return $this;
    }

    public function setHitpoints($hitpoints) {
        $this->hitpoints = $hitpoints;
        return $this;
    }

    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    public function setAlwaysVisible($alwaysVisible) {
        $this->alwaysVisible = $alwaysVisible;
        return $this;
    }

    public function getRecipe(): array {
        return $this->recipe;
    }
}
