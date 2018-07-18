<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of CharacterSkill
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="characterskills")
 */
class CharacterSkill {
    /**
     *
     * @var Character 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;
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
    
    public function getCharacter(): Character {
        return $this->character;
    }

    public function getSkill(): Skill {
        return $this->skill;
    }

    public function getPoints() {
        return $this->points;
    }

    public function setCharacter(Character $character) {
        $this->character = $character;
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
