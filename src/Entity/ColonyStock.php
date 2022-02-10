<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ColonyStock
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="colonystocks")
 */
class ColonyStock {
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony", inversedBy="stocks")
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
     * @ORM\Column(type="bigint") 
     */
    protected $stocks = 0;
    
    public function getColony(): Colony {
        return $this->colony;
    }

    public function getResource(): Resource {
        return $this->resource;
    }

    public function getStocks() {
        return $this->stocks;
    }

    public function setColony(Colony $colony) {
        $this->colony = $colony;
        return $this;
    }

    public function setResource(Resource $resource) {
        $this->resource = $resource;
        return $this;
    }

    public function setStocks($stocks) {
        $this->stocks = $stocks;
        return $this;
    }


}
