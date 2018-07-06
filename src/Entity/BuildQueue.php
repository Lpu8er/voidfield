<?php
namespace App\Entity;

/**
 * Description of BuildQueue
 *
 * @author lpu8er
 */
class BuildQueue {
    protected $building;
    protected $player;
    protected $colony;
    protected $startDate;
    protected $estimatedEndDate;
    protected $lastQueueCheckDate;
    protected $points; // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 building built
}
