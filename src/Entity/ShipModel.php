<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ShipModel
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="shipmodels")
 */
class ShipModel {
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
     * @var bool
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    protected $deleted = false; // we don't delete a shipmodel : we deactive it.
    /**
     *
     * @var Hull 
     * @ORM\ManyToOne(targetEntity="Hull")
     * @ORM\JoinColumn(name="hull_id", referencedColumnName="id")
     */
    protected $hull;
    /**
     *
     * @var Module[]
     * @ORM\ManyToMany(targetEntity="Module")
     * @ORM\JoinTable(name="shipmodels_modules",
     *      joinColumns={@ORM\JoinColumn(name="shipmodel_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="module_id", referencedColumnName="id")}
     * )
     */
    protected $modules;
    /**
     *
     * @var integer
     * @ORM\Column(type="bigint", options={"default" : 0})
     */
    protected $baseCost = 0;
    /**
     *
     * @var integer
     * @ORM\Column(type="bigint", options={"default" : 0})
     */
    protected $energyBuild = 0;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 0})
     */
    protected $speed = 0.;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 0})
     */
    protected $mass = 0.;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5, options={"default" : 0})
     */
    protected $size = 0.;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $signature = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $energyConsumation = 0; // flat value of energy consuming
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $energyBase = 0; // base energy apport
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $maxCargoMass = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $maxCargoSize = 0;
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=true)
     */
    protected $owner = null;
    
    /**
     *
     * @var ShipModelRecipe[]
     * @ORM\OneToMany(targetEntity="ShipModelRecipe", mappedBy="shipModel")
     */
    protected $recipe;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->recipe = new ArrayCollection();
    }

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

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getBaseCost(): ?int
    {
        return $this->baseCost;
    }

    public function setBaseCost(int $baseCost): self
    {
        $this->baseCost = $baseCost;

        return $this;
    }

    public function getEnergyBuild(): ?int
    {
        return $this->energyBuild;
    }

    public function setEnergyBuild(int $energyBuild): self
    {
        $this->energyBuild = $energyBuild;

        return $this;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getMass()
    {
        return $this->mass;
    }

    public function setMass($mass): self
    {
        $this->mass = $mass;

        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSignature(): ?int
    {
        return $this->signature;
    }

    public function setSignature(int $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getEnergyConsumation(): ?int
    {
        return $this->energyConsumation;
    }

    public function setEnergyConsumation(int $energyConsumation): self
    {
        $this->energyConsumation = $energyConsumation;

        return $this;
    }

    public function getEnergyBase(): ?int
    {
        return $this->energyBase;
    }

    public function setEnergyBase(int $energyBase): self
    {
        $this->energyBase = $energyBase;

        return $this;
    }

    public function getMaxCargoMass(): ?int
    {
        return $this->maxCargoMass;
    }

    public function setMaxCargoMass(int $maxCargoMass): self
    {
        $this->maxCargoMass = $maxCargoMass;

        return $this;
    }

    public function getMaxCargoSize(): ?int
    {
        return $this->maxCargoSize;
    }

    public function setMaxCargoSize(int $maxCargoSize): self
    {
        $this->maxCargoSize = $maxCargoSize;

        return $this;
    }

    public function getHull(): ?Hull
    {
        return $this->hull;
    }

    public function setHull(?Hull $hull): self
    {
        $this->hull = $hull;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    } // if null, public/system model
    
    /**
     * @return Collection|ShipModelRecipe[]
     */
    public function getRecipe(): Collection
    {
        return $this->recipe;
    }

    public function addRecipe(ShipModelRecipe $recipe): self
    {
        if (!$this->recipe->contains($recipe)) {
            $this->recipe[] = $recipe;
        }

        return $this;
    }

    public function removeRecipe(ShipModelRecipe $recipe): self
    {
        if ($this->recipe->contains($recipe)) {
            $this->recipe->removeElement($recipe);
        }

        return $this;
    }
}
