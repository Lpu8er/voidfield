<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ProductionQueue
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="productionqueues")
 */
class ProductionQueue {
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
    /**
     *
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", name="korder")
     */
    protected $order;
    protected $shipModel;
    protected $nb;
    protected $startDate;
    protected $estimatedEndDate;
    protected $lastQueueCheckDate;
    protected $points; // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 building built
}
