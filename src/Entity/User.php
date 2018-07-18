<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of User
 * 
 * When registered, some things happen:
 * * a character is generated
 *
 * @author lpu8er
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements \Symfony\Component\Security\Core\User\UserInterface, \Serializable {
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SHADOW = 'shadow';
    const STATUS_BOT = 'bot';
    const STATUS_HOLIDAY = 'holiday';
    const STATUS_BAN = 'ban';
    
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
    protected $username;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $email;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=200)
     */
    protected $pwd;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=20)
     */
    protected $status;
    /**
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $admin = false;
    /**
     *
     * @var Character
     * @ORM\OneToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="maincharacter_id", referencedColumnName="id", nullable=true)
     */
    protected $mainCharacter = null;
    /**
     *
     * @var integer
     * @ORM\Column(type="bigint")
     */
    protected $money = 0;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $firstConnection = null;
    /**
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $rookie = true;
    
    public function __construct() {
        $this->status = static::STATUS_INACTIVE;
    }
    
    public function getPassword() {
        return $this->pwd;
    }
    
    public function getRoles() {
        $r = [];
        if(static::STATUS_BOT === $this->status) { $r[] = 'ROLE_BOT'; }
        else { $r[] = 'ROLE_USER'; }
        if($this->admin) { $r[] = 'ROLE_ADMIN'; }
        if(!empty($this->mainCharacter)) { // fun fact : this is in Sf cache so will trigger some issues if changed without a full roles refresh
            $r[] = 'ROLE_VERIFIED';
        }
        return $r;
    }
    
    public function getSalt() {
        return null;
    }
    
    public function eraseCredentials() { }
    
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->pwd,
        ));
    }
    
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->pwd,
        ) = unserialize($serialized, array('allowed_classes' => false));
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
    
    public function getAdmin() {
        return $this->admin;
    }

    public function getMainCharacter() {
        return $this->mainCharacter;
    }

    public function getMoney() {
        return $this->money;
    }

    public function getFirstConnection() {
        return $this->firstConnection;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
        return $this;
    }

    public function setMainCharacter(Character $mainCharacter) {
        $this->mainCharacter = $mainCharacter;
        return $this;
    }

    public function setMoney($money) {
        $this->money = $money;
        return $this;
    }

    public function setFirstConnection(\DateTime $firstConnection) {
        $this->firstConnection = $firstConnection;
        return $this;
    }
    
    public function getRookie() {
        return $this->rookie;
    }

    public function setRookie($rookie) {
        $this->rookie = $rookie;
        return $this;
    }


}
