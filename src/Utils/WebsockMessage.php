<?php
namespace App\Utils;

use App\Service\RatchetHandler;
use Ratchet\ConnectionInterface;

/**
 * Description of WebsockMessage
 *
 * @author lpu8er
 */
abstract class WebsockMessage {
    protected $baseData = null;
    
    final public function __construct($baseData) {
        $this->baseData = $baseData;
    }
    
    abstract public function execute(RatchetHandler $handler, ConnectionInterface $src);
}
