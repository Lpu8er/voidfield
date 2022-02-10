<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ColonyProduction
 * This object is modified each time that it should be through buildings
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="colonyproductions")
 */
class ColonyProduction {
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
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
    
    public function getColony(): Colony {
        return $this->colony;
    }

    public function getResource(): Resource {
        return $this->resource;
    }

    public function getNb() {
        return $this->nb;
    }

    public function setColony(Colony $colony) {
        $this->colony = $colony;
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
