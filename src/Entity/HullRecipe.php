<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of HullRecipe
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="hullrecipes")
 */
class HullRecipe {
    /**
     *
     * @var Hull 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Hull")
     * @ORM\JoinColumn(name="hull_id", referencedColumnName="id")
     */
    protected $hull;
    /**
     *
     * @var Resource 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Resource")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     */
    protected $resource;
    protected $nb;
    protected $recyclable; // resource that can be taken back if prod is cancelled
}
