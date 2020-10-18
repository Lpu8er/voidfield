<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Fleet
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="fleets")
 */
class Fleet {
    const BEHAVIOUR_PASSIVE = 'psv'; // don't move, just stay static don't assault anything
    const BEHAVIOUR_AGGRESSIVE = 'agg'; // don't move, assault anything coming in
    const BEHAVIOUR_SEEKNDESTROY = 'snd'; // move and search anything to destroy in the current system or celestial
    const BEHAVIOUR_EVASIVE = 'evs'; // move randomly without assaulting anything (big hyatus between each move)
    
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
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $publicName;
    /**
     *
     * @var System 
     * @ORM\ManyToOne(targetEntity="System")
     * @ORM\JoinColumn(name="system_id", referencedColumnName="id")
     */
    protected $system; // if not travelling (or when travelling current system) needs to be probed
    /**
     *
     * @var Celestial 
     * @ORM\ManyToOne(targetEntity="Celestial")
     * @ORM\JoinColumn(name="celestial_id", referencedColumnName="id", nullable=true)
     */
    protected $celestial = null; // if on orbit or docked
    /**
     *
     * @var Colony 
     * @ORM\ManyToOne(targetEntity="Colony", inversedBy="fleets")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id", nullable=true)
     */
    protected $colony = null; // if docked
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=10)
     */
    protected $behaviour;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $maxTargetStanding;
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;
    /**
     *
     * @var Character 
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="commander_id", referencedColumnName="id", nullable=true)
     */
    protected $commander = null;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $baseSignature;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $visibleSignature;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $bestScanStrength; // best scan strength
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $x;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $y;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $z;
    
    /**
     * If the fleet is currently in battle.
     * This status is special and lock abilities to do stuff with fleet, so it'll serve as a "lock semaphore"
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $battling;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSystem(): System {
        return $this->system;
    }

    public function getCelestial() {
        return $this->celestial;
    }

    public function getColony() {
        return $this->colony;
    }

    public function getBehaviour() {
        return $this->behaviour;
    }

    public function getMaxTargetStanding() {
        return $this->maxTargetStanding;
    }

    public function getOwner(): User {
        return $this->owner;
    }

    public function getCommander() {
        return $this->commander;
    }

    public function getBaseSignature() {
        return $this->baseSignature;
    }

    public function getVisibleSignature() {
        return $this->visibleSignature;
    }

    public function getBestScanStrength() {
        return $this->bestScanStrength;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    public function getZ() {
        return $this->z;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSystem(System $system) {
        $this->system = $system;
        return $this;
    }

    public function setCelestial(Celestial $celestial = null) {
        $this->celestial = $celestial;
        return $this;
    }

    public function setColony(Colony $colony = null) {
        $this->colony = $colony;
        return $this;
    }

    public function setBehaviour($behaviour) {
        $this->behaviour = $behaviour;
        return $this;
    }

    public function setMaxTargetStanding($maxTargetStanding) {
        $this->maxTargetStanding = $maxTargetStanding;
        return $this;
    }

    public function setOwner(User $owner) {
        $this->owner = $owner;
        return $this;
    }

    public function setCommander(Character $commander = null) {
        $this->commander = $commander;
        return $this;
    }

    public function setBaseSignature($baseSignature) {
        $this->baseSignature = $baseSignature;
        return $this;
    }

    public function setVisibleSignature($visibleSignature) {
        $this->visibleSignature = $visibleSignature;
        return $this;
    }

    public function setBestScanStrength($bestScanStrength) {
        $this->bestScanStrength = $bestScanStrength;
        return $this;
    }

    public function setX($x) {
        $this->x = $x;
        return $this;
    }

    public function setY($y) {
        $this->y = $y;
        return $this;
    }

    public function setZ($z) {
        $this->z = $z;
        return $this;
    }

    public function getBattling(): ?bool
    {
        return $this->battling;
    }

    public function setBattling(bool $battling): self
    {
        $this->battling = $battling;

        return $this;
    }

    public function getPublicName(): string {
        return $this->publicName;
    }

    public function setPublicName(string $publicName) {
        $this->publicName = $publicName;
        return $this;
    }


}
