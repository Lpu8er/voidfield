<?php
namespace App\Controller;

use App\Entity\Building;
use App\Entity\Colony;
use Symfony\Component\HttpFoundation\Request;
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
    public function detail(Request $request, $cid) {
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
    
    /**
     * 
     * @Route("/colony/{cid}/build", name="colony_build", requirements={"cid"="\d+"}, methods={"POST"})
     */
    public function build(Request $request, $cid) {
        if($request->request->has('bid')) {
            $bid = intval($request->request->get('bid'));
            if(!empty($bid)
                && $request->request->has('_csrf')
                && $this->isCsrfTokenValid('colony-'.$cid.'-build-'.strval($bid), $request->request->get('_csrf'))) {
                
            }
        }
        return $this->redirectToRoute('colony_detail', [
            'cid' => $cid,
            '_fragment' => 'buildings-tabpane',
        ]);
    }
}
