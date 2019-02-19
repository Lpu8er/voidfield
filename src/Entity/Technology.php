<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Technology
 *
 * @author lpu8er
 * @ORM\Entity(repositoryClass="App\Repository\TechnologyRepository")
 * @ORM\Table(name="technologies")
 */
class Technology {
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
     * @var User 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateFound; // @TODO add a second date "train" to allow mid time (replicate and train all colonies)
}
