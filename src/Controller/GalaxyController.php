<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of GalaxyController
 *
 * @author lpu8er
 * @Route("/galaxy")
 */
class GalaxyController extends InternalController {
    /**
     * @Route("/", name="galaxy")
     */
    public function galaxy(Request $request) {
        throw $this->createNotFoundException();
    }
}
