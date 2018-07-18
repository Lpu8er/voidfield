<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of FleetShip
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="fleetships")
 */
class FleetShip {
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * If null, model was discontinued
     * @var ShipModel
     * @ORM\ManyToOne(targetEntity="ShipModel")
     * @ORM\JoinColumn(name="shipmodel_id", referencedColumnName="id", nullable=true)
     */
    protected $shipModel = null;
    /**
     *
     * @var Fleet
     * @ORM\ManyToOne(targetEntity="Fleet")
     * @ORM\JoinColumn(name="fleet_id", referencedColumnName="id", nullable=true)
     */
    protected $fleet = null; // if undocked or in fleet
    /**
     *
     * @var Colony
     * @ORM\ManyToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id", nullable=true)
     */
    protected $colony = null; // if docked, out of fleet
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $nb;
    /**
     *
     * @var Hull
     * @ORM\ManyToOne(targetEntity="Hull")
     * @ORM\JoinColumn(name="hull_id", referencedColumnName="id")
     */
    protected $hull;
    /**
     *
     * @var Module[]
     * @ORM\ManyToMany(targetEntity="Module")
     * @ORM\JoinTable(name="fleetship_modules",
     *      joinColumns={@ORM\JoinColumn(name="fleetship_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="module_id", referencedColumnName="id")}
     * )
     */
    protected $modules;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $baseCost;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energyBuild;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $speed;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $mass;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $size;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $signature;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energyConsumation; // flat value of energy consuming
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $energyBase; // base energy apport
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $maxCargoMass;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $maxCargoSize;
    
    public function getId() {
        return $this->id;
    }

    public function getShipModel() {
        return $this->shipModel;
    }

    public function getFleet() {
        return $this->fleet;
    }

    public function getColony() {
        return $this->colony;
    }

    public function getNb() {
        return $this->nb;
    }

    public function getHull(): Hull {
        return $this->hull;
    }

    public function getModules() {
        return $this->modules;
    }

    public function getBaseCost() {
        return $this->baseCost;
    }

    public function getEnergyBuild() {
        return $this->energyBuild;
    }

    public function getSpeed() {
        return $this->speed;
    }

    public function getMass() {
        return $this->mass;
    }

    public function getSize() {
        return $this->size;
    }

    public function getSignature() {
        return $this->signature;
    }

    public function getEnergyConsumation() {
        return $this->energyConsumation;
    }

    public function getEnergyBase() {
        return $this->energyBase;
    }

    public function getMaxCargoMass() {
        return $this->maxCargoMass;
    }

    public function getMaxCargoSize() {
        return $this->maxCargoSize;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setShipModel(ShipModel $shipModel = null) {
        $this->shipModel = $shipModel;
        return $this;
    }

    public function setFleet(Fleet $fleet = null) {
        $this->fleet = $fleet;
        return $this;
    }

    public function setColony(Colony $colony = null) {
        $this->colony = $colony;
        return $this;
    }

    public function setNb($nb) {
        $this->nb = $nb;
        return $this;
    }

    public function setHull(Hull $hull) {
        $this->hull = $hull;
        return $this;
    }

    public function setModules(array $modules) {
        $this->modules = $modules;
        return $this;
    }

    public function setBaseCost($baseCost) {
        $this->baseCost = $baseCost;
        return $this;
    }

    public function setEnergyBuild($energyBuild) {
        $this->energyBuild = $energyBuild;
        return $this;
    }

    public function setSpeed($speed) {
        $this->speed = $speed;
        return $this;
    }

    public function setMass($mass) {
        $this->mass = $mass;
        return $this;
    }

    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    public function setSignature($signature) {
        $this->signature = $signature;
        return $this;
    }

    public function setEnergyConsumation($energyConsumation) {
        $this->energyConsumation = $energyConsumation;
        return $this;
    }

    public function setEnergyBase($energyBase) {
        $this->energyBase = $energyBase;
        return $this;
    }

    public function setMaxCargoMass($maxCargoMass) {
        $this->maxCargoMass = $maxCargoMass;
        return $this;
    }

    public function setMaxCargoSize($maxCargoSize) {
        $this->maxCargoSize = $maxCargoSize;
        return $this;
    }


}
