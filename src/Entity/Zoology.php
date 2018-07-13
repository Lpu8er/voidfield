<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Zoology
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="zoologies")
 */
class Zoology {
    const NEVER = 0;
    const LIVING_LAND = 1;
    const LIVING_WATER = 2;
    const LIVING_ATMOSPHERIC = 4;
    const LIVING_ORBITAL = 8;
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $name;
    protected $description;
    protected $hostility; // can attack ?
    protected $weakness; // can easily be destroyed by climatic changes ?
    protected $intelligence; // percent of effectiveness for attacks
    protected $scariness; // passive modifier
    protected $naturalLiving;
    protected $effectiveness; // optimal number for 100% effect
    protected $toxicityCleaning; // clean toxicity of the natural living
}
