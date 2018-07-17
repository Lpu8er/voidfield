<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Skill
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="skills")
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
    const ATTRIBUTE_SCANSTRENGTH = 'scanstrength';
    const ATTRIBUTE_DAILYINCOME = 'dailyincome';
    
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
     * @var string
     * @ORM\Column(type="string")
     */
    protected $attribute;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    protected $value;
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $damageType = null;
    /**
     * 
     * @var Resource
     * @ORM\ManyToOne(targetEntity="Resource")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=true)
     */
    protected $resource = null;
    /**
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $usableOnCharacter = false;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getAttribute() {
        return $this->attribute;
    }

    public function getValue() {
        return $this->value;
    }

    public function getDamageType() {
        return $this->damageType;
    }

    public function getResource() {
        return $this->resource;
    }

    public function getUsableOnCharacter(): bool {
        return $this->usableOnCharacter;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setAttribute($attribute) {
        $this->attribute = $attribute;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setDamageType($damageType) {
        $this->damageType = $damageType;
        return $this;
    }

    public function setResource(Resource $resource = null) {
        $this->resource = $resource;
        return $this;
    }

    public function setUsableOnCharacter(bool $usableOnCharacter) {
        $this->usableOnCharacter = $usableOnCharacter;
        return $this;
    }


}
