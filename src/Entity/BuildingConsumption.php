<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BuildingConsumption
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="buildingconsumptions")
 */
class BuildingConsumption {
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
     * @var Resource 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Resource")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     */
    protected $resource;
    protected $nb;
}
