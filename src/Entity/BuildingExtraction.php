<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BuildingExtraction
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="buildingextractions")
 */
class BuildingExtraction {
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
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $nb;
    
    public function getBuilding(): Building {
        return $this->building;
    }

    public function getResource(): Resource {
        return $this->resource;
    }

    public function getNb() {
        return $this->nb;
    }

    public function setBuilding(Building $building) {
        $this->building = $building;
        return $this;
    }

    public function setResource(Resource $resource) {
        $this->resource = $resource;
        return $this;
    }

    public function setNb($nb) {
        $this->nb = $nb;
        return $this;
    }


}
