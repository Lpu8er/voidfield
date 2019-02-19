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
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * 
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hostility; // can attack ?
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $weakness; // can easily be destroyed by climatic changes ?
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $intelligence; // percent of effectiveness for attacks
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $scariness; // passive modifier
    /**
     *
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $naturalLiving;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $effectiveness; // optimal number for 100% effect
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $toxicityCleaning; // clean toxicity of the natural living
}
