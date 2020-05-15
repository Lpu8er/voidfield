<?php
namespace App\Entity;

/**
 * Description of VirtualBuilding
 *
 * @author lpu8er
 */
class VirtualBuilding extends Building {
    public static function factory(Building $b): self {
        
    }
    
    public function setId($id): self {
        return parent::setId($id);
    }
    
    /**
     *
     * @var float 
     */
    protected $cost = 0;
    /**
     *
     * @var string 
     */
    protected $duration;
    
    public function getCost(): float {
        return $this->cost;
    }

    public function getDuration(): string {
        return $this->duration;
    }

    public function setCost(float $cost) {
        $this->cost = $cost;
        return $this;
    }

    public function setDuration(string $duration) {
        $this->duration = $duration;
        return $this;
    }
}
