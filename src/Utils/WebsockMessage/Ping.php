<?php
namespace App\Utils\WebsockMessage;

use App\Service\RatchetHandler;
use App\Utils\WebsockMessage;
use Ratchet\ConnectionInterface;

/**
 * Description of Ping
 *
 * @author lpu8er
 */
class Ping extends WebsockMessage {
    public function execute(RatchetHandler $handler, ConnectionInterface $src) {
        $src->send(json_encode(['pong' => microtime(true),]));
    }
}
