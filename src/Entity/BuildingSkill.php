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
    protected $points;
}
