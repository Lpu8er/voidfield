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
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $dateNotify;
    protected $dateRead;
    protected $content;
    protected $notifType;
    protected $targetPlayer;
}
