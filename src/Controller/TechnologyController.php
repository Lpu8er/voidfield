<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of TechnologyController
 *
 * @author lpu8er
 * @Route("/tech")
 */
class TechnologyController extends InternalController {
    /**
     * @Route("/", name="tech")
     */
    public function tech(Request $request) {
        throw $this->createNotFoundException();
    }
}
