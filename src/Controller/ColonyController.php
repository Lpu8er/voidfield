<?php
namespace App\Controller;

use App\Entity\Building;
use App\Entity\Colony;
use App\Entity\ColonyExtraction;
use App\Entity\ColonyProduction;
use Exception;
use Psr\Log\LoggerInterface;
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
                    'extractors' => $this->getDoctrine()->getRepository(ColonyExtraction::class)->findBy(['colony' => $colony->getId(),]),
                    'productors' => $this->getDoctrine()->getRepository(ColonyProduction::class)->findBy(['colony' => $colony->getId(),]),
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
    public function build(Request $request, LoggerInterface $logger, $cid) {
        if($request->request->has('bid')) {
            $bid = intval($request->request->get('bid'));
            if(!empty($bid)
                && $request->request->has('_csrf')
                && $this->isCsrfTokenValid('colony-'.$cid.'-build-'.strval($bid), $request->request->get('_csrf'))) {
                $colony = $this->getDoctrine()->getRepository(Colony::class)->find($cid);
                $building = $this->getDoctrine()->getRepository(Building::class)->find($bid);
                try {
                    if($this->getDoctrine()->getRepository(Building::class)->build($building, $colony)) {
                        $this->addMessage('ok', 'ok !', true);
                    } else {
                        $this->addMessage('error', 'oopsie', true);
                    }
                } catch(Exception $e) {
                    $logger->error($e->getMessage());
                    $logger->error($e->getTraceAsString());
                    $this->addMessage('error', 'Une erreur est apparue', true);
                }
            } else {
                $this->addMessage('error', 'XSRF error', true);
            }
        } else {
            $this->addMessage('error', 'No building IG provided', true);
        }
        return $this->redirectToRoute('colony_detail', [
            'cid' => $cid,
            '_fragment' => 'buildings-tabpane',
        ]);
    }
    
    /**
     * 
     * @Route("/colony/{cid}/toggle", name="colony_building_toggle", requirements={"cid"="\d+"}, methods={"POST"})
     */
    public function changeRunningBuilding(Request $request, LoggerInterface $logger, $cid) {
        if($request->request->has('bid')) {
            $bid = intval($request->request->get('bid'));
            if(!empty($bid)
                && $request->request->has('_csrf')
                && $this->isCsrfTokenValid('colony-'.$cid.'-running-'.strval($bid), $request->request->get('_csrf'))) {
                $buildRepo = $this->getDoctrine()->getRepository(Building::class); /** @var \App\Repository\BuildingRepository $buildRepo */
                $colRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var \App\Repository\ColonyRepository $colRepo */
                $colony = $colRepo->find($cid);
                $building = $buildRepo->find($bid);
                try {
                    $colRepo->changeRunningBuilding($building, $colony, min(100, max(0, intval($request->request->get('val', 0)))));
                } catch(Exception $e) {
                    $logger->error($e->getMessage());
                    $logger->error($e->getTraceAsString());
                    $this->addMessage('error', 'Une erreur est apparue', true);
                }
            } else {
                $this->addMessage('error', 'XSRF error', true);
            }
        } else {
            $this->addMessage('error', 'No building IG provided', true);
        }
        return $this->redirectToRoute('colony_detail', [
            'cid' => $cid,
            '_fragment' => 'buildings-tabpane',
        ]);
    }
}
