<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Natural
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="naturals")
 */
class Natural {
    /**
     *
     * @var Celestial 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Celestial")
     * @ORM\JoinColumn(name="celestial_id", referencedColumnName="id")
     */
    protected $celestial; // ofc, stargates and stations won't have any of those
    /**
     *
     * @var Resource 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Resource")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     */
    protected $resource;
    /**
     *
     * @var int
     * @ORM\Column(type="bigint") 
     */
    protected $stocks = 0; // current natural stocks; stocks is filled by production each day, deplated by extraction, meaning that's the max a colony can extract by day
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $production = 0.0; // natural production; that value will periodically move by the replating value depending on resource type
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $replating = 0.0; // natural replate (negative : deplate); negative events and mass extraction will lower that value
}
