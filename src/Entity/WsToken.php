<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of WsToken
 *
 * @author lpu8er
 * @ORM\Entity(repositoryClass="App\Repository\WsTokenRepository")
 * @ORM\Table(name="wstokens")
 */
class WsToken {
    /**
     * Token is ready to use
     */
    const STATUS_READY = 'ready';
    /**
     * Token is in use
     */
    const STATUS_CONNECTED = 'connected';
    /**
     * Token was tried to be used by an invalid IP or bearer
     */
    const STATUS_INVALIDATED = 'invalidated';
    /**
     * Token was set as expired
     */
    const STATUS_EXPIRED = 'expired';
    
    /**
     *
     * @var User 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $player;
    
    /**
     * Generation date
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateGen = null;
    
    /**
     * Regeneration date, which is renewed each time the WS heartbeat
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateRegen = null;
    
    /**
     * Expiration date, which is renewed each time the WS heartbeat
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateExpire = null;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $status = null;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $token;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $ip;
    
    public function getPlayer(): User {
        return $this->player;
    }

    public function getDateGen(): DateTime {
        return $this->dateGen;
    }

    public function getDateRegen(): DateTime {
        return $this->dateRegen;
    }

    public function getDateExpire(): DateTime {
        return $this->dateExpire;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function getIp(): string {
        return $this->ip;
    }

    public function setPlayer(User $player) {
        $this->player = $player;
        return $this;
    }

    public function setDateGen(DateTime $dateGen) {
        $this->dateGen = $dateGen;
        return $this;
    }

    public function setDateRegen(DateTime $dateRegen) {
        $this->dateRegen = $dateRegen;
        return $this;
    }

    public function setDateExpire(DateTime $dateExpire) {
        $this->dateExpire = $dateExpire;
        return $this;
    }

    public function setStatus(string $status) {
        $this->status = $status;
        return $this;
    }

    public function setToken(string $token) {
        $this->token = $token;
        return $this;
    }

    public function setIp(string $ip) {
        $this->ip = $ip;
        return $this;
    }
}
