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
     * @var ShipModel 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ShipModel")
     * @ORM\JoinColumn(name="shipmodel_id", referencedColumnName="id")
     */
    protected $shipModel;
    /**
     *
     * @var Fleet 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Fleet")
     * @ORM\JoinColumn(name="fleet_id", referencedColumnName="id")
     */
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
