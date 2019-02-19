<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ShipModelRecipe
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="shipmodelrecipes")
 */
class ShipModelRecipe {
    /**
     *
     * @var ShipModel 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ShipModel")
     * @ORM\JoinColumn(name="shipmodel_id", referencedColumnName="id")
     */
    protected $shipModel;
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
     * @ORM\Column(type="integer")
     */
    protected $nb;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $recyclable; // resource that can be taken back if prod is cancelled
}
