<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of System
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="systems")
 */
class System {
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
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     *
     * @var Galaxy 
     * @ORM\ManyToOne(targetEntity="Galaxy")
     * @ORM\JoinColumn(name="galaxy_id", referencedColumnName="id")
     */
    protected $galaxy;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $centerX;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $centerY;
    /**
     * 
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $centerZ;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getGalaxy(): Galaxy {
        return $this->galaxy;
    }

    public function getCenterX() {
        return $this->centerX;
    }

    public function getCenterY() {
        return $this->centerY;
    }

    public function getCenterZ() {
        return $this->centerZ;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setGalaxy(Galaxy $galaxy) {
        $this->galaxy = $galaxy;
        return $this;
    }

    public function setCenterX($centerX) {
        $this->centerX = $centerX;
        return $this;
    }

    public function setCenterY($centerY) {
        $this->centerY = $centerY;
        return $this;
    }

    public function setCenterZ($centerZ) {
        $this->centerZ = $centerZ;
        return $this;
    }


}
