<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of IntelController
 *
 * @author lpu8er
 * @Route("/intel")
 */
class IntelController extends InternalController {
    /**
     * @Route("/", name="intel")
     */
    public function intel(Request $request) {
        throw $this->createNotFoundException();
    }
    
    /**
     * @Route("/alliances", name="alliances")
     */
    public function alliances() {
        $list = $this->getDoctrine()->getRepository(\App\Entity\Alliance::class)->findAll();
        return $this->sr('intel/alliances', ['alliances' => $list,], 'intel');
    }
}
