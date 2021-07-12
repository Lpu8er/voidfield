<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Skill
 *
 * @author lpu8er
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 * @ORM\Table(name="skills")
 */
class Skill implements \JsonSerializable {
    /**
     * attack	Modifie l'attaque d'un ou de tous les attributs
     */
    const ATTRIBUTE_ATTACK = 'attack';
    /**
     * defense	Modifie la défense face à un ou tous les attributs
     */
    const ATTRIBUTE_DEFENSE = 'defense';
    /**
     * production	Modifie la production pure d'une ou toutes les ressources
     */
    const ATTRIBUTE_PRODUCTION = 'production';
    /**
     * stocksize	Le stock en taille possible d'une ou toutes les ressources
     */
    const ATTRIBUTE_STOCKSIZE = 'stocksize';
    /**
     * stockmass	Le stock en masse possible d'une ou toutes les ressources
     */
    const ATTRIBUTE_STOCKMASS = 'stockmass';
    /**
     * speed	Vitesse des flottes
     */
    const ATTRIBUTE_SPEED = 'speed';
    /**
     * energyconso	Consommation en énergie
     */
    const ATTRIBUTE_ENERGYCONSUMPTION = 'energyconso';
    /**
     * energyprod	Production d'énergie
     */
    const ATTRIBUTE_ENERGYPROD = 'energyprod';
    /**
     * energystock	Stockage d'énergie
     */
    const ATTRIBUTE_ENERGYSTOCK = 'energystock';
    /**
     * morale	Modificateur de morale, en % de population influé
     */
    const ATTRIBUTE_MORALE = 'morale';
    /**
     * dailycost	Modificateur global de coût en pognon journalier des infra
     */
    const ATTRIBUTE_DAILYCOST = 'dailycost';
    /**
     * buildcost	Modificateur global de coût de construction en pognon
     */
    const ATTRIBUTE_BUILDCOST = 'buildcost';
    /**
     * prodspeed	Modificateur de vitesse de production d'une ou toutes les ressources
     */
    const ATTRIBUTE_PRODSPEED = 'prodspeed';
    /**
     * buildspeed	Modificateur de vitesse de construction
     */
    const ATTRIBUTE_BUILDSPEED = 'buildspeed';
    /**
     * zoology	Modificateur d'influence négative des zoologies
     */
    const ATTRIBUTE_ZOOLOGY = 'zoology';
    /**
     * researchspeed	Modificateur global de vitesse de recherche
     */
    const ATTRIBUTE_RESEARCHSPEED = 'researchspeed';
    /**
     * workersconso	Modificateur d'utilisation des travailleurs
     */
    const ATTRIBUTE_WORKERSCONSUMPTION = 'workersconso';
    /**
     * workersprod	Modificateur de production des travailleurs
     */
    const ATTRIBUTE_WORKERSPROD = 'workersprod';
    /**
     * workersstock	Modificateur de stock des travailleurs
     */
    const ATTRIBUTE_WORKERSSTOCK = 'workersstock';
    /**
     * scanstrength	Force de scan (radar...)
     */
    const ATTRIBUTE_SCANSTRENGTH = 'scanstrength';
    /**
     * dailyincome	Modificateur du revenu journalier via taxe
     */
    const ATTRIBUTE_DAILYINCOME = 'dailyincome';
    /**
     * extract	Modifie l'extraction d'une ou toutes les ressources
     */
    const ATTRIBUTE_EXTRACT = 'extract';
    /**
     * planetology  Etendue des informations disponibles sur la planète
     */
    const ATTRIBUTE_PLANETOLOGY = 'planetology';
    /**
     * stargate-discover  Découverte des stargate, détection
     */
    const ATTRIBUTE_SPECIAL_STARGATE_DISCOVER = 'stargate-discover';
    /**
     * stargate-use  Utilisation des stargate
     */
    const ATTRIBUTE_SPECIAL_STARGATE_USE = 'stargate-use';
    
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'points' => $this->getPoints(),
        ];
    }
    
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
    /**
     *
     * @var int
     */
    protected $points = 0;
    
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

    public function getPoints(): int {
        return $this->points;
    }

    public function setPoints(int $points) {
        $this->points = $points;
        return $this;
    }


}
