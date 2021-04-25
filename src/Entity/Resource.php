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
class Resource implements \JsonSerializable {
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
     * @ORM\Column(type="string", length=5, unique=true)
     */
    protected $skey;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $name;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=50)
     */
    protected $unicode;
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
    
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'icon' => $this->getUnicode(),
        ];
    }
    
    public function getId(): int {
        return $this->id;
    }

    function getSkey(): string {
        return $this->skey;
    }

        
    public function getName(): string {
        return $this->name;
    }

    public function getMass(): float {
        return $this->mass;
    }

    public function getSize(): float {
        return $this->size;
    }

    public function getNutritive(): float {
        return $this->nutritive;
    }

    public function getRestricted(): int {
        return $this->restricted;
    }

    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }
    
    function setSkey(string $skey): self {
        $this->skey = $skey;
        return $this;
    }

    
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function setMass(float $mass): self {
        $this->mass = $mass;
        return $this;
    }

    public function setSize(float $size): self {
        $this->size = $size;
        return $this;
    }

    public function setNutritive(float $nutritive): self {
        $this->nutritive = $nutritive;
        return $this;
    }

    public function setRestricted(int $restricted): self {
        $this->restricted = $restricted;
        return $this;
    }

        
    public function getUnicode(): string {
        return $this->unicode;
    }

    public function setUnicode(string $unicode) {
        $this->unicode = $unicode;
        return $this;
    }


}
