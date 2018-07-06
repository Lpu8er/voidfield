<?php
namespace App\Entity;

/**
 * Description of FleetShip
 *
 * @author lpu8er
 */
class FleetShip {
    protected $shipModel;
    protected $fleet;
    protected $nb;
    protected $hull;
    protected $modules;
    protected $baseCost;
    protected $energyBuild;
    protected $speed;
    protected $mass;
    protected $size;
    protected $signature;
    protected $energyConsumation; // flat value of energy consuming
    protected $energyBase; // base energy apport
    protected $maxCargoMass;
    protected $maxCargoSize;
}
