<?php
namespace App\Entity;

/**
 * Description of ShipModelRecipe
 *
 * @author lpu8er
 */
class ShipModelRecipe {
    protected $shipModel;
    protected $resource;
    protected $nb;
    protected $recyclable; // resource that can be taken back if prod is cancelled
}
