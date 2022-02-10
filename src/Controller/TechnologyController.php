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
        $techRepo = $this->getDoctrine()->getRepository(\App\Entity\Technology::class); /** @var \App\Repository\TechnologyRepository $techRepo */
        return $this->sr('technologies/list', [
            'technologies' => $techRepo->tree($this->getUser()),
            'found' => $techRepo->findBy([
                'player' => $this->getUser()->getId(),
            ]),
        ]);
    }
}
