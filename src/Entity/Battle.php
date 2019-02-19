<?php
namespace App\Entity;

/**
 * Description of Battle
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="battles")
 */
class Battle {
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
     * @var BattlePart[]
     */
    protected $parts;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $startDate;
}
