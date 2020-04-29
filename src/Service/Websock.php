<?php
namespace App\Service;

use App\Service\RatchetHandler;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

/**
 * Description of Websock
 *
 * @author lpu8er
 */
class Websock {
    protected $ratchetHandler = null;
    
    public function __construct(RatchetHandler $ratchetHandler) {
        $this->ratchetHandler = $ratchetHandler;
    }
    
    public function init() {
        $server = IoServer::factory(
                new HttpServer(
                        new WsServer(
                                $this->ratchetHandler
                            )
                    ), 8080);
        $server->run();
    }
}
