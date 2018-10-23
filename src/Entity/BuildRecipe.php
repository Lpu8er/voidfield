<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BuildRecipe
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="buildrecipes")
 */
class BuildRecipe {
    /**
     *
     * @var Building 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Building", inversedBy="recipe")
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
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $recyclable; // resource that can be taken back if build is cancelled
    
    public function getBuilding(): Building {
        return $this->building;
    }

    public function getResource(): Resource {
        return $this->resource;
    }

    public function getNb() {
        return $this->nb;
    }

    public function getRecyclable() {
        return $this->recyclable;
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

    public function setRecyclable($recyclable) {
        $this->recyclable = $recyclable;
        return $this;
    }


}
