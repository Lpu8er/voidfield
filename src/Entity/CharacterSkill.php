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
}
