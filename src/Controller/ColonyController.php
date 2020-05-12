<?php
namespace App\Controller;

use App\Entity\Building;
use App\Entity\Colony;
use Symfony\Component\Routing\Annotation\Route;

class ColonyController extends InternalController {
    /**
     * @Route("/colonies", name="colonies_list")
     */
    public function index() {
        
    }
    
    /**
     * @Route("/colony/{cid}", name="colony_detail", requirements={"cid"="\d+"})
     */
    public function detail($cid) {
        $returns = null;
        $colony = $this->getDoctrine()->getRepository(Colony::class)->find($cid);
        if(!empty($colony) && ($this->getUser()->getId() === $colony->getOwner()->getId())) {
            $returns = $this->render('internal/colonies/detail.html.twig', [
                'colony' => $colony,
                'stocks' => $this->getDoctrine()->getRepository(Colony::class)->getPaddedResources($colony),
                'buildable' => $this->getDoctrine()->getRepository(Building::class)->visibleList($colony),
                ]);
        } else {
            throw $this->createAccessDeniedException();
        }
        return $returns;
    }
}
