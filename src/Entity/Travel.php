<?php
namespace App\Entity;

/**
 * Description of Travel
 *
 * @author lpu8er
 */
class Travel {
    protected $fleet; // id
    protected $startSystem;
    protected $startCelestial;
    protected $startColony;
    protected $endSystem;
    protected $endCelestial;
    protected $endColony;
    protected $startDate;
    protected $estimatedDndDate;
    protected $estimatedDuration;
    protected $currentDuration;
}
