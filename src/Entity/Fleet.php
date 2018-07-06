<?php
namespace App\Entity;

/**
 * Description of Fleet
 *
 * @author lpu8er
 */
class Fleet {
    const BEHAVIOUR_PASSIVE = 'psv'; // don't move, just stay static don't assault anything
    const BEHAVIOUR_AGGRESSIVE = 'agg'; // don't move, assault anything coming in
    const BEHAVIOUR_SEEKNDESTROY = 'snd'; // move and search anything to destroy in the current system or celestial
    const BEHAVIOUR_EVASIVE = 'evs'; // move randomly without assaulting anything (big hyatus between each move)
    
    protected $id;
    protected $name;
    protected $system; // if not travelling (or when travelling current system) needs to be probed
    protected $celestial; // if on orbit or docked
    protected $colony; // if docked
    protected $behaviour;
    protected $maxTargetStanding;
    protected $commander;
    protected $baseSignature;
    protected $visibleSignature;
}
