<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Notification
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="notifications")
 */
class Notification {
    const NOTIFTYPE_GENERIC = 'generic';
    const NOTIFTYPE_ERROR = 'ko';
    const NOTIFTYPE_WARN = 'warn';
    const NOTIFTYPE_INFO = 'info';
    const NOTIFTYPE_OK = 'ok';
    
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
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $dateSent;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateNotify = null;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateRead = null;
    /**
     *
     * @var string 
     * @ORM\Column(type="text")
     */
    protected $content;
    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=20)
     */
    protected $notifType;
    /**
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $targetPlayer;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getDateNotify(): ?\DateTime {
        return $this->dateNotify;
    }

    public function getDateRead(): ?\DateTime {
        return $this->dateRead;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getNotifType(): string {
        return $this->notifType;
    }

    public function getTargetPlayer(): User {
        return $this->targetPlayer;
    }

    public function getDateSent(): \DateTime {
        return $this->dateSent;
    }

    public function setDateSent(\DateTime $dateSent) {
        $this->dateSent = $dateSent;
        return $this;
    }

        
    public function setDateNotify(?\DateTime $dateNotify) {
        $this->dateNotify = $dateNotify;
        return $this;
    }

    public function setDateRead(?\DateTime $dateRead) {
        $this->dateRead = $dateRead;
        return $this;
    }

    public function setContent(string $content) {
        $this->content = $content;
        return $this;
    }

    public function setNotifType(string $notifType) {
        $this->notifType = $notifType;
        return $this;
    }

    public function setTargetPlayer(User $targetPlayer) {
        $this->targetPlayer = $targetPlayer;
        return $this;
    }
}
