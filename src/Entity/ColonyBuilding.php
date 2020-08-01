<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ColonyBuilding
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="colonybuildings")
 */
class ColonyBuilding implements \JsonSerializable {
    /**
     *
     * @var Building 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Building")
     * @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     */
    protected $building;
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony", inversedBy="buildings")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $running = 100; // percent of func, allow energy and resources saving
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $integrity = 100;
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $level = 1;
    
    public function jsonSerialize() {
        return [
            'buildingId' => $this->building->getId(),
            'colonyId' => $this->colony->getId(),
            'running' => $this->running,
            'integrity' => $this->integrity,
        ];
    }

    public function getRunning(): ?int
    {
        return $this->running;
    }

    public function setRunning(int $running): self
    {
        $this->running = $running;

        return $this;
    }

    public function getIntegrity(): ?int
    {
        return $this->integrity;
    }

    public function setIntegrity(int $integrity): self
    {
        $this->integrity = $integrity;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getColony(): ?Colony
    {
        return $this->colony;
    }

    public function setColony(?Colony $colony): self
    {
        $this->colony = $colony;

        return $this;
    } // percent of integrity, lower the func
    
    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }
}
