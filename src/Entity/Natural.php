<?php
namespace App\Entity;

/**
 * Description of Natural
 *
 * @author lpu8er
 */
class Natural {
    protected $celestial; // ofc, stargates and stations won't have any of those
    protected $resource;
    protected $stocks; // current natural stocks; stocks is filled by production each day, deplated by extraction, meaning that's the max a colony can extract by day
    protected $production; // natural production; that value will periodically move by the replating value depending on resource type
    protected $replating; // natural replate (negative : deplate); negative events and mass extraction will lower that value
}
