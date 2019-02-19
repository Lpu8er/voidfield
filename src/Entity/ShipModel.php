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
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * 
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $deleted; // we don't delete a shipmodel : we deactive it.
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
     * @ORM\OneToMany(targetEntity="Module")
     */
    protected $modules;
    /**
     *
     * @var integer
     * @ORM\Column(type="bigint")
     */
    protected $baseCost;
    /**
     *
     * @var integer
     * @ORM\Column(type="bigint")
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
    /**
     *
     * @var User 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner = null; // if null, public/system model
}
