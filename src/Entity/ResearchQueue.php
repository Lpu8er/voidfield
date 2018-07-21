<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ResearchQueue
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researchqueue")
 */
class ResearchQueue {
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
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony", inversedBy="searchqueue")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $player;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $startDate;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $estimatedEndDate;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $lastQueueCheckDate;
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $points; // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 technology won
}
