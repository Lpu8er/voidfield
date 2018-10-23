<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Research
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researches")
 */
class Research {
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
     * @var Resource 
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="replacing_id", referencedColumnName="id")
     */
    protected $replacing; // if that replace a previous one (previous level, usually)
    /**
     *
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $baseDuration;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $searchCost;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $points; // how many points (minutes) it needs
}
