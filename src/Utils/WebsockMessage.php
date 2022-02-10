<?php
namespace App\Utils;

use App\Entity\WsToken;
use App\Service\RatchetHandler;
use Ratchet\ConnectionInterface;

/**
 * Description of WebsockMessage
 *
 * @author lpu8er
 */
abstract class WebsockMessage {
    protected $baseData = null;
    protected $wsToken = null;
    
    final public function __construct($baseData, WsToken $wsToken = null) {
        $this->baseData = $baseData;
        $this->wsToken = $wsToken;
    }
    
    final public function getIp(ConnectionInterface $c) {
        return $c->remoteAddress;
    }
    
    abstract public function execute(RatchetHandler $handler, ConnectionInterface $src);
}
