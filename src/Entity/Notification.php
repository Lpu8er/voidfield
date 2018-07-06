<?php
namespace App\Entity;

/**
 * Description of Notification
 *
 * @author lpu8er
 */
class Notification {
    const NOTIFTYPE_GENERIC = 'generic';
    
    protected $id;
    protected $dateNotify;
    protected $dateRead;
    protected $content;
    protected $notifType;
    protected $targetPlayer;
}
