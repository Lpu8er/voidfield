<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Planetology
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="planetologies")
 */
class Planetology {
    /**
     *
     * @var Planet 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Planet")
     * @ORM\JoinColumn(name="planet_id", referencedColumnName="id")
     */
    protected $planet;
    /**
     *
     * @var Zoology 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Zoology")
     * @ORM\JoinColumn(name="zoology_id", referencedColumnName="id")
     */
    protected $zoology;
    protected $nb;

    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    public function setPlanet(?Planet $planet): self
    {
        $this->planet = $planet;

        return $this;
    }

    public function getZoology(): ?Zoology
    {
        return $this->zoology;
    }

    public function setZoology(?Zoology $zoology): self
    {
        $this->zoology = $zoology;

        return $this;
    }
}
