<?php
namespace App\Entity;

/**
 * Description of Fleet
 *
 * @author lpu8er
 */
class Fleet {
    protected $id;
    protected $name;
    protected $system; // if not travelling (or when travelling current system) needs to be probed
    protected $celestial; // if on orbit or docked
    protected $colony; // if docked
}
