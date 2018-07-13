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
    protected $name;
    protected $replacing; // if that replace a previous one (previous level, usually)
    protected $baseDuration;
    protected $searchCost;
    protected $points; // how many points (minutes) it needs
}
