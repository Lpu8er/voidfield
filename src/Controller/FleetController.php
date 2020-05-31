<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of FleetController
 *
 * @author lpu8er
 * @Route("/fleet")
 */
class FleetController extends InternalController {
    /**
     * @Route("/", name="fleet")
     */
    public function fleet(Request $request) {
        throw $this->createNotFoundException();
    }
}
