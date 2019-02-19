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
     * @ORM\ManyToOne(targetEntity="Research")
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
    protected $nb;
    protected $recyclable;

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
    } // resource that can be taken back if research is cancelled
}
