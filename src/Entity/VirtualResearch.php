<?php
namespace App\Entity;

use App\Utils\Toolbox;

/**
 * Description of VirtualResearch
 *
 * @author lpu8er
 */
class VirtualResearch extends Research {
    public static function factory(Research $b): self {
        return Toolbox::shallow($b, new VirtualResearch);
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
     * @var bool 
     */
    protected $canBeSearched = false;
    
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
    
    public function getCanBeSearched(): bool {
        return $this->canBeSearched;
    }

    public function setCanBeSearched(bool $canBeSearched) {
        $this->canBeSearched = $canBeSearched;
        return $this;
    }
}
