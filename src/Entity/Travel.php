<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Travel
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="travels")
 */
class Travel {
    /**
     *
     * @var Fleet 
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Fleet")
     * @ORM\JoinColumn(name="fleet_id", referencedColumnName="id")
     */
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
