<?php
namespace App\Service;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

/**
 * Description of RatchetHandler
 *
 * @author lpu8er
 */
class RatchetHandler implements MessageComponentInterface {
    /**
     *
     * @var SplObjectStorage
     */
    protected $clients = null;
    
    /**
     *
     * @var WebsockMessageHandler 
     */
    protected $messageHandler = null;
    
    public function __construct(WebsockMessageHandler $messageHandler) {
        $this->messageHandler = $messageHandler;
        $this->clients = new SplObjectStorage;
    }
    
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }
    
    public function onMessage(ConnectionInterface $from, $msg) {
        $message = $this->messageHandler->parse(json_decode($msg, true), $from);
        if(!empty($message)) {
            $message->execute($this, $from);
        }
    }
    
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }
    
    public function onError(ConnectionInterface $conn, Exception $e) {
        echo $e->getMessage()."\n".$e->getTraceAsString();
        $conn->close();
    }
    
    public function broadcast($data) {
        foreach($this->clients as $client) {
            $client->send($data);
        }
    }
}
