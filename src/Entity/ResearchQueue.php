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
     * @ORM\ManyToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
    protected $player;
    protected $startDate;
    protected $estimatedEndDate;
    protected $lastQueueCheckDate;
    protected $points; // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 technology won
}
