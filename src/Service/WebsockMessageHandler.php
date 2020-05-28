<?php
namespace App\Service;

use App\Utils\iWebsockAuthable;
use App\Utils\WebsockMessage;
use Doctrine\Persistence\ManagerRegistry;
use Ratchet\ConnectionInterface;


/**
 * Transform an arbitrary structure received by websock to a WebsockMessage
 * @author lpu8er
 */
class WebsockMessageHandler {
    protected $doctrine = null;
    protected $wsAuth = null;
    protected $commands = null;
    
    public function __construct(ManagerRegistry $doctrine, WebsockAuth $wsAuth, array $commands) {
        $this->doctrine = $doctrine;
        $this->commands = $commands;
        $this->wsAuth = $wsAuth;
    }
    
    /**
     * 
     * @param array $data
     * @return WebsockMessage|null
     */
    public function parse($data, ConnectionInterface $connection): ?WebsockMessage {
        $returns = null;
        if(is_array($data)
                && array_key_exists('cmd', $data)) {
            if(array_key_exists($data['cmd'], $this->commands)) {
                $cls = $this->commands[$data['cmd']];
                // auth ?
                if(!is_a($cls, iWebsockAuthable::class)) {
                    $returns = new $cls(array_key_exists('data', $data)? $data['data']:[]);
                } elseif(!empty($data['token']) && ($wst = $this->wsAuth->checkAuth($data['token'], $connection))) {
                    $returns = new $cls(array_key_exists('data', $data)? $data['data']:[], $wst);
                }
            }
        }
        return $returns;
    }
}
