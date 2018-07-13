<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ResearchSkill
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researchskills")
 */
class ResearchSkill {
    /**
     *
     * @var Research 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="research_id", referencedColumnName="id")
     */
    protected $research;
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
