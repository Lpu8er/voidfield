<?php
namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of GlobalController
 *
 * @author lpu8er
 */
abstract class GlobalController extends AbstractController {
    /**
     *
     * @var string 
     */
    protected $current = null;
    
    /**
     *
     * @var array
     */
    protected $messages = [];
    
    /**
     * 
     * @param string $type (use notice, warning, error, success... see alert-cls)
     * @param string $message
     * @param bool $delayed
     * @return $this
     */
    protected function addMessage(string $type, string $message, bool $delayed = false, ?DateTime $when = null): self {
        if($delayed) {
            $this->addFlash($type, $message);
        } else {
            if(!array_key_exists($type, $this->messages)) {
                $this->messages[$type] = [];
            }
            $this->messages[$type][] = ['message' => $message, 'date' => $when,];
        }
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    protected function getMessages(): array {
        return $this->messages;
    }
    
    /**
     * 
     * @param string $current
     * @return $this
     */
    protected function setCurrent(string $current): self {
        $this->current = $current;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    protected function getCurrent() {
        return $this->current;
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
        $parameters['_current'] = $this->getCurrent();
        return parent::render($view, $parameters, $response);
    }
}
