<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of HullRecipe
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="hullrecipes")
 */
class HullRecipe {
    /**
     *
     * @var Hull 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Hull")
     * @ORM\JoinColumn(name="hull_id", referencedColumnName="id")
     */
    protected $hull;
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

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    } // resource that can be taken back if prod is cancelled
}
