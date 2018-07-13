<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Planetology
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="planetologies")
 */
class Planetology {
    /**
     *
     * @var Planet 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Planet")
     * @ORM\JoinColumn(name="planet_id", referencedColumnName="id")
     */
    protected $planet;
    /**
     *
     * @var Zoology 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Zoology")
     * @ORM\JoinColumn(name="zoology_id", referencedColumnName="id")
     */
    protected $zoology;
    protected $nb;
}
