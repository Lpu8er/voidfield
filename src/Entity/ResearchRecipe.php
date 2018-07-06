<?php
namespace App\Entity;

/**
 * Description of ResearchRecipe
 *
 * @author lpu8er
 */
class ResearchRecipe {
    protected $research;
    protected $resource;
    protected $nb;
    protected $recyclable; // resource that can be taken back if research is cancelled
}
