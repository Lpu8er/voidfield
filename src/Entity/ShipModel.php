<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ShipModel
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="shipmodels")
 */
class ShipModel {
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
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
    protected $owner = null; // if null, public/system model
}
