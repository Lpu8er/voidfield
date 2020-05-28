<?php
namespace App\Utils\WebsockMessage;

use App\Service\RatchetHandler;
use App\Utils\iWebsockAuthable;
use App\Utils\WebsockMessage;
use Ratchet\ConnectionInterface;

/**
 * Description of Aping
 *
 * @author lpu8er
 */
class Aping extends WebsockMessage implements iWebsockAuthable {
    public function execute(RatchetHandler $handler, ConnectionInterface $src) {
        $src->send(json_encode(['pong' => microtime(true),]));
    }
}
