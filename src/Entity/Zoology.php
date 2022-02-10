<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Zoology
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="zoologies")
 */
class Zoology {
    const NEVER = 0;
    const LIVING_LAND = 1;
    const LIVING_WATER = 2;
    const LIVING_ATMOSPHERIC = 4;
    const LIVING_ORBITAL = 8;
    
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
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hostility; // can attack ?
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $weakness; // can easily be destroyed by climatic changes ?
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $intelligence; // percent of effectiveness for attacks
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $scariness; // passive modifier
    /**
     *
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $naturalLiving;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $effectiveness; // optimal number for 100% effect
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $toxicityCleaning;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHostility(): ?int
    {
        return $this->hostility;
    }

    public function setHostility(int $hostility): self
    {
        $this->hostility = $hostility;

        return $this;
    }

    public function getWeakness(): ?int
    {
        return $this->weakness;
    }

    public function setWeakness(int $weakness): self
    {
        $this->weakness = $weakness;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getScariness(): ?int
    {
        return $this->scariness;
    }

    public function setScariness(int $scariness): self
    {
        $this->scariness = $scariness;

        return $this;
    }

    public function getNaturalLiving(): ?int
    {
        return $this->naturalLiving;
    }

    public function setNaturalLiving(int $naturalLiving): self
    {
        $this->naturalLiving = $naturalLiving;

        return $this;
    }

    public function getEffectiveness(): ?int
    {
        return $this->effectiveness;
    }

    public function setEffectiveness(int $effectiveness): self
    {
        $this->effectiveness = $effectiveness;

        return $this;
    }

    public function getToxicityCleaning(): ?int
    {
        return $this->toxicityCleaning;
    }

    public function setToxicityCleaning(int $toxicityCleaning): self
    {
        $this->toxicityCleaning = $toxicityCleaning;

        return $this;
    } // clean toxicity of the natural living
}
