<?php
namespace App\Entity;

/**
 * Description of ShipModel
 *
 * @author lpu8er
 */
class ShipModel {
    protected $id;
    protected $name;
    protected $deleted; // we don't delete a shipmodel : we deactive it.
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
