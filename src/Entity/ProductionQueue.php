<?php
namespace App\Entity;

/**
 * Description of ProductionQueue
 *
 * @author lpu8er
 */
class ProductionQueue {
    protected $colony;
    protected $order;
    protected $shipModel;
    protected $nb;
    protected $startDate;
    protected $estimatedEndDate;
    protected $lastQueueCheckDate;
    protected $points; // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 building built
}
