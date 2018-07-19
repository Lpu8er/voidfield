<?php
namespace App\Controller;

use App\Entity\Colony;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of InternalController
 *
 * @author lpu8er
 */
abstract class InternalController extends GlobalController {
    /**
     *
     * @var Colony
     */
    protected $currentColony = null;
    
    /**
     * 
     * @param Colony $colony
     * @return $this
     */
    public function setCurrentColony(Colony $colony = null): self {
        $this->currentColony = $colony;
        return $this;
    }
    
    /**
     * 
     * @return Colony
     */
    public function getCurrentColony() {
        return $this->currentColony;
    }
    
    /**
     * 
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return mixed
     */
    protected function render(string $view, array $parameters = array(), Response $response = null): Response {
        $parameters['_colony'] = $this->getCurrentColony();
        return parent::render($view, $parameters, $response);
    }
}
