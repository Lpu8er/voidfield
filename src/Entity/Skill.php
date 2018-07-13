<?php
namespace App\Entity;

/**
 * Description of Skill
 *
 * @author lpu8er
 */
class Skill {
    const ATTRIBUTE_ATTACK = 'attack';
    const ATTRIBUTE_DEFENSE = 'defense';
    const ATTRIBUTE_PRODUCTION = 'production';
    const ATTRIBUTE_STOCKSIZE = 'stocksize';
    const ATTRIBUTE_STOCKMASS = 'stockmass';
    const ATTRIBUTE_SPEED = 'speed';
    const ATTRIBUTE_ENERGYCONSUMPTION = 'energyconso';
    const ATTRIBUTE_ENERGYPROD = 'energyprod';
    const ATTRIBUTE_ENERGYSTOCK = 'energystock';
    const ATTRIBUTE_MORALE = 'morale';
    const ATTRIBUTE_DAILYCOST = 'dailycost';
    const ATTRIBUTE_BUILDCOST = 'buildcost';
    const ATTRIBUTE_PRODSPEED = 'prodspeed';
    const ATTRIBUTE_BUILDSPEED = 'buildspeed';
    const ATTRIBUTE_ZOOLOGY = 'zoology';
    const ATTRIBUTE_RESEARCHSPEED = 'researchspeed';
    const ATTRIBUTE_WORKERSCONSUMPTION = 'workersconso';
    const ATTRIBUTE_WORKERSPROD = 'workersprod';
    const ATTRIBUTE_WORKERSSTOCK = 'workersstock';
    
    protected $id;
    protected $name;
    protected $attribute;
    protected $value;
    protected $damageType;
    protected $resource;
}
