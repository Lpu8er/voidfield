<?php
namespace App\Entity;

/**
 * Description of ResearchQueue
 *
 * @author lpu8er
 */
class ResearchQueue {
    protected $research;
    protected $player;
    protected $colony;
    protected $startDate;
    protected $estimatedEndDate;
    protected $lastQueueCheckDate;
    protected $points; // how many cumulated points still left. Lost, by default, 1 point by minute depending on current - lastQueueCheckDate, once at 0 technology won
}
