<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Resource
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="resources")
 */
class Resource {
    const NO_PROD = 0;
    const RESTRICT_EARTH = 1;
    const RESTRICT_WATER = 2;
    const RESTRICT_AIR = 4;
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $name;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $mass;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $size;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $nutritive = 0; // nutritive value
    /**
     *
     * @var int 
     * @ORM\Column(type="integer")
     */
    protected $restricted;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getMass() {
        return $this->mass;
    }

    public function getSize() {
        return $this->size;
    }

    public function getNutritive() {
        return $this->nutritive;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setMass($mass) {
        $this->mass = $mass;
        return $this;
    }

    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    public function setNutritive($nutritive) {
        $this->nutritive = $nutritive;
        return $this;
    }

    public function getRestricted() {
        return $this->restricted;
    }

    public function setRestricted($restricted) {
        $this->restricted = $restricted;
        return $this;
    }


}
