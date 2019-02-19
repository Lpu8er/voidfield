<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Alliance
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="alliances")
 */
class Alliance {
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
     * @var string
     * @ORM\Column(type="string")
     */
    protected $ticker;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $foundationDate;
    /**
     *
     * @var Character 
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="founder_id", referencedColumnName="id")
     */
    protected $founder;
    /**
     *
     * @var Character 
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="founder_id", referencedColumnName="id")
     */
    protected $leader;
}
