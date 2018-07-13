<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ColonyBuilding
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="colonybuildings")
 */
class ColonyBuilding {
    /**
     *
     * @var Building 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Building")
     * @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     */
    protected $building;
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
    protected $running; // percent of func, allow energy and resources saving
    protected $integrity; // percent of integrity, lower the func
}
