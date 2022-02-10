<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ColonySkill
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="colonyskills")
 */
class ColonySkill {
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
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
    
    public function getColony(): Colony {
        return $this->colony;
    }

    public function getSkill(): Skill {
        return $this->skill;
    }

    public function getPoints() {
        return $this->points;
    }

    public function setColony(Colony $colony) {
        $this->colony = $colony;
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
