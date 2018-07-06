<?php
namespace App\Entity;

/**
 * Description of BuildRecipe
 *
 * @author lpu8er
 */
class BuildRecipe {
    protected $building;
    protected $resource;
    protected $nb;
    protected $recyclable; // resource that can be taken back if build is cancelled
}
