<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Research
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researches")
 */
class Research implements iRecipeCapable {
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     *
     * @var Resource 
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="replacing_id", referencedColumnName="id")
     */
    protected $replacing; // if that replace a previous one (previous level, usually)
    /**
     *
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $baseDuration;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $searchCost;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $points;
    
    /**
     *
     * @var ResearchRecipe[]
     * @ORM\OneToMany(targetEntity="ResearchRecipe", mappedBy="research")
     */
    protected $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBaseDuration(): ?string
    {
        return $this->baseDuration;
    }

    public function setBaseDuration(string $baseDuration): self
    {
        $this->baseDuration = $baseDuration;

        return $this;
    }

    public function getSearchCost(): ?int
    {
        return $this->searchCost;
    }

    public function setSearchCost(int $searchCost): self
    {
        $this->searchCost = $searchCost;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getReplacing(): ?self
    {
        return $this->replacing;
    }

    public function setReplacing(?self $replacing = null): self
    {
        $this->replacing = $replacing;

        return $this;
    } // how many points (minutes) it needs
    
    public function getRecipe() {
        return $this->recipe;
    }

    public function addRecipe(ResearchRecipe $recipe): self
    {
        if (!$this->recipe->contains($recipe)) {
            $this->recipe[] = $recipe;
            $recipe->setResearch($this);
        }

        return $this;
    }

    public function removeRecipe(ResearchRecipe $recipe): self
    {
        if ($this->recipe->contains($recipe)) {
            $this->recipe->removeElement($recipe);
            // set the owning side to null (unless already changed)
            if ($recipe->getResearch() === $this) {
                $recipe->setResearch(null);
            }
        }

        return $this;
    }
}
