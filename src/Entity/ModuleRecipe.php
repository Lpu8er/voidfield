<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ModuleRecipe
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="modulerecipes")
 */
class ModuleRecipe {
    /**
     *
     * @var Hull 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="recipe")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     */
    protected $module;
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
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $recyclable = 0;

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    } // resource that can be taken back if prod is cancelled
    
    public function getNb(): int {
        return $this->nb;
    }

    public function getRecyclable(): int {
        return $this->recyclable;
    }

    public function setNb(int $nb) {
        $this->nb = $nb;
        return $this;
    }

    public function setRecyclable(int $recyclable) {
        $this->recyclable = $recyclable;
        return $this;
    }
}
