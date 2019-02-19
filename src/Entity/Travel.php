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
    /**
     *
     * @var System 
     * @ORM\OneToOne(targetEntity="System")
     * @ORM\JoinColumn(name="start_system_id", referencedColumnName="id")
     */
    protected $startSystem;
    /**
     *
     * @var Celestial 
     * @ORM\OneToOne(targetEntity="Celestial")
     * @ORM\JoinColumn(name="start_celestial_id", referencedColumnName="id", nullable=true)
     */
    protected $startCelestial = null;
    /**
     *
     * @var Colony 
     * @ORM\OneToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="start_colony_id", referencedColumnName="id", nullable=true)
     */
    protected $startColony = null;
    /**
     *
     * @var System 
     * @ORM\OneToOne(targetEntity="System")
     * @ORM\JoinColumn(name="end_system_id", referencedColumnName="id")
     */
    protected $endSystem;
    /**
     *
     * @var Celestial 
     * @ORM\OneToOne(targetEntity="Celestial")
     * @ORM\JoinColumn(name="end_celestial_id", referencedColumnName="id", nullable=true)
     */
    protected $endCelestial;
    /**
     *
     * @var Colony 
     * @ORM\OneToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="end_colony_id", referencedColumnName="id", nullable=true)
     */
    protected $endColony;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startDate;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $estimatedEndDate;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $estimatedDuration;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $currentDuration;
}
