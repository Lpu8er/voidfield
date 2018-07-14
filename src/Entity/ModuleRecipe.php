<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ModuleRecipe
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="modulerecipes")
 */
class ModuleRecipe {
    /**
     *
     * @var Hull 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     */
    protected $module;
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
