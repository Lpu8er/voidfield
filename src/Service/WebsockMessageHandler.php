<?php
namespace App\Service;

use App\Utils\WebsockMessage;

/**
 * Transform an arbitrary structure received by websock to a WebsockMessage
 * @author lpu8er
 */
class WebsockMessageHandler {
    protected $commands = null;
    
    public function __construct(array $commands) {
        $this->commands = $commands;
    }
    
    /**
     * 
     * @param array $data
     * @return WebsockMessage|null
     */
    public function parse($data): ?WebsockMessage {
        $returns = null;
        if(is_array($data)
                && array_key_exists('cmd', $data)) {
            if(array_key_exists($data['cmd'], $this->commands)) {
                $cls = $this->commands[$data['cmd']];
                $returns = new $cls(array_key_exists('data', $data)? $data['data']:[]);
            }
        }
        return $returns;
    }
}
