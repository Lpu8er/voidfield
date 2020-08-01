<?php
namespace App\Entity;

use App\Utils\Toolbox;

/**
 * Description of VirtualBuilding
 *
 * @author lpu8er
 */
class VirtualBuilding extends Building {
    public static function factory(Building $b): self {
        return Toolbox::shallow($b, new VirtualBuilding);
    }
    
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'canBeBuilt' => $this->canBeBuilt,
            'cost' => $this->cost,
            'duration' => $this->duration,
            'insufficientResources' => $this->insufficientResources,
        ];
    }
    
    public function setId($id): self {
        return parent::setId($id);
    }
    
    /**
     * To allow deep-copy
     * @param array $recipe
     * @return $this
     */
    public function setRecipe($recipe): self {
        $this->recipe = $recipe;
        return $this;
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
    /**
     *
     * @var int 
     */
    protected $builtLevel = 0;
    /**
     *
     * @var bool 
     */
    protected $canBeBuilt = false;
    /**
     *
     * @var array 
     */
    protected $insufficientResources = [];
    
    /**
     * Virtual shorthand method
     * @return bool
     */
    public function getEmptyRecipe(): bool {
        $isEmpty = true;
        foreach($this->getRecipe() as $recipe) { $isEmpty = false; break; }
        return $isEmpty;
    }
    
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
    
    public function getBuiltLevel(): int {
        return $this->builtLevel;
    }

    public function setBuiltLevel(int $builtLevel) {
        $this->builtLevel = $builtLevel;
        return $this;
    }
    
    public function getCanBeBuilt(): bool {
        return $this->canBeBuilt;
    }

    public function getInsufficientResources(): array {
        return $this->insufficientResources;
    }

    public function setCanBeBuilt(bool $canBeBuilt) {
        $this->canBeBuilt = $canBeBuilt;
        return $this;
    }

    public function setInsufficientResources(array $insufficientResources) {
        $this->insufficientResources = $insufficientResources;
        return $this;
    }
}
