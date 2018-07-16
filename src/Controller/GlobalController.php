<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of GlobalController
 *
 * @author lpu8er
 */
abstract class GlobalController extends Controller {
    /**
     *
     * @var array
     */
    protected $messages = [];
    
    /**
     * 
     * @param string $type
     * @param string $message
     * @param bool $delayed
     * @return $this
     */
    protected function addMessage(string $type, string $message, bool $delayed = false): self {
        if($delayed) {
            $this->addFlash($type, $message);
        } else {
            if(!array_key_exists($type, $this->messages)) {
                $this->messages[$type] = [];
            }
            $this->messages[$type][] = $message;
        }
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    protected function getMessages() {
        return $this->messages;
    }
    
    /**
     * 
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return mixed
     */
    protected function render(string $view, array $parameters = array(), Response $response = null): Response {
        $parameters['_messages'] = $this->getMessages();
        return parent::render($view, $parameters, $response);
    }
}
