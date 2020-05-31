<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ResearchRecipe
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researchrecipes")
 */
class ResearchRecipe {
    /**
     *
     * @var Research 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Research", inversedBy="recipe")
     * @ORM\JoinColumn(name="research_id", referencedColumnName="id")
     */
    protected $research;
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
    protected $nb;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $recyclable = 0;

    public function getResearch(): ?Research
    {
        return $this->research;
    }

    public function setResearch(?Research $research): self
    {
        $this->research = $research;

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
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(int $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    public function getRecyclable(): ?int
    {
        return $this->recyclable;
    }

    public function setRecyclable(int $recyclable): self
    {
        $this->recyclable = $recyclable;

        return $this;
    } // resource that can be taken back if research is cancelled
}
