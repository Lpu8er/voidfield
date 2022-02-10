<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BuildingSkill
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="buildingskills")
 */
class BuildingSkill {
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
     * @var Skill 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Skill")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    protected $skill;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $points;
    
    public function getBuilding(): Building {
        return $this->building;
    }

    public function getSkill(): Skill {
        return $this->skill;
    }

    public function getPoints() {
        return $this->points;
    }

    public function setBuilding(Building $building) {
        $this->building = $building;
        return $this;
    }

    public function setSkill(Skill $skill) {
        $this->skill = $skill;
        return $this;
    }

    public function setPoints($points) {
        $this->points = $points;
        return $this;
    }


}
