<?php
namespace App\Controller;

use App\Entity\Building;
use App\Entity\Colony;
use App\Entity\ColonyExtraction;
use App\Entity\ColonyProduction;
use App\Entity\Natural;
use App\Repository\BuildingRepository;
use App\Repository\ColonyRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ColonyController extends InternalController {
    /**
     * @Route("/colonies", name="colonies")
     */
    public function index() {
        $returns = [];
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colonies = $coloRepo->findByOwner($this->getUser()->getId()); /** @var Colony[] $colonies */ // we don't output straight, because we have more info
        foreach($colonies as $colony) {
            $returns[] = array_merge($colony->jsonSerialize(), [
                'duration' => null,
            ]);
        }
        return $this->json($returns);
    }
    
    /**
     * @Route("/colonies/{cid}/res", name="colony_resources", requirements={"cid"="\d+"})
     */
    public function resources(Request $request, $cid) {
        $returns = [];
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony)
                && !empty($colony->getOwner())
                && ($colony->getOwner()->getId() == $this->getUser()->getId())) {
            $returns = $coloRepo->getPaddedResources($colony);
        } else {
            $returnCode = JsonResponse::HTTP_NOT_FOUND;
        }
        return $this->json($returns, $returnCode);
    }
    
    /**
     * @Route("/colonies/{cid}", name="colony_details", requirements={"cid"="\d+"})
     */
    public function detail(Request $request, $cid) {
        $returns = null;
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $buildRepo = $this->getDoctrine()->getRepository(Building::class); /** @var BuildingRepository $buildRepo */
        $techRepo = $this->getDoctrine()->getRepository(\App\Entity\Technology::class); /** @var \App\Repository\TechnologyRepository $techRepo */
        $fleetRepo = $this->getDoctrine()->getRepository(\App\Entity\Fleet::class);
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony)) {
            if(!empty($colony->getOwner())
                && ($colony->getOwner()->getId() == $this->getUser()->getId())) {
                $returns = $this->sr('colonies/owner_details', [
                    'colony' => $colony,
                    'stocks' => $coloRepo->getPaddedResources($colony),
                    'hasSpaceport' => $coloRepo->hasSpaceport($colony),
                    'hasSpacefactory' => $coloRepo->hasSpacefactory($colony),
                    'buildable' => $buildRepo->visibleList($colony),
                    'fleets' => $fleetRepo->findByColony($colony),
                    'technologies' => $techRepo->visibleList($colony),
                    'searchqueue' => $this->getDoctrine()->getRepository(\App\Entity\ResearchQueue::class)->findOneBy([
                        'colony' => $cid,
                    ]),
                ]);
            } else {
                $returns = $this->sr('colonies/other_details', [
                    'colony' => $colony
                ]);
            }
        } else {
            $returns = $this->createNotFoundException('This colony does not exist.');
        }
        return $returns;
    }
    
    /**
     * @Route("/colonies/{cid}/buildings", name="colony_buildings", requirements={"cid"="\d+"})
     */
    public function buildings(Request $request, $cid) {
        $returns = null;
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony)
                && !empty($colony->getOwner())
                && ($colony->getOwner()->getId() == $this->getUser()->getId())) {
            $buildRepo = $this->getDoctrine()->getRepository(Building::class); /** @var BuildingRepository $buildRepo */
            $returns = $colony->getBuildings();
        } else {
            $returnCode = JsonResponse::HTTP_NOT_FOUND;
        }
        return $this->json($returns, $returnCode);
    }
    
    /**
     * @Route("/colonies/{cid}/bqueue", name="colony_building_queue", requirements={"cid"="\d+"})
     */
    public function buildingqueue(Request $request, $cid) {
        $returns = null;
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony)
                && !empty($colony->getOwner())
                && ($colony->getOwner()->getId() == $this->getUser()->getId())) {
            $buildRepo = $this->getDoctrine()->getRepository(Building::class); /** @var BuildingRepository $buildRepo */
            $returns = $colony->getBuildqueue();
        } else {
            $returnCode = JsonResponse::HTTP_NOT_FOUND;
        }
        return $this->json($returns, $returnCode);
    }
    
    /**
     * @Route("/colonies/{cid}/buildable", name="colony_buildable", requirements={"cid"="\d+"})
     */
    public function buildable(Request $request, $cid) {
        $returns = null;
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony)
                && !empty($colony->getOwner())
                && ($colony->getOwner()->getId() == $this->getUser()->getId())) {
            $buildRepo = $this->getDoctrine()->getRepository(Building::class); /** @var BuildingRepository $buildRepo */
            $returns = $buildRepo->visibleList($colony);
        } else {
            $returnCode = JsonResponse::HTTP_NOT_FOUND;
        }
        return $this->json($returns, $returnCode);
    }
    
    /**
     * @Route("/colonies/{cid}/fleets", name="colony_fleets", requirements={"cid"="\d+"})
     */
    public function fleets(Request $request, $cid) {
        $returns = [];
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        $fleets = $this->getDoctrine()->getRepository(\App\Entity\Fleet::class)->findBy([
            'colony' => $colony->getId()
        ]);
        foreach($fleets as $f) { /** @var \App\Entity\Fleet $f */
            $owned = ($f->getOwner() == $this->getUser()->getId());
            $lf = [
                'id' => $f->getId(),
                'name' => $owned? $f->getName():null,
                'publicName' => $f->getPublicName(),
                'signature' => $f->getVisibleSignature(),
                'behaviour' => $owned? $f->getBehaviour():null,
                'colonyId' => $cid,
                'battling' => false,
                'commanderId' => ($owned && !empty($f->getCommander()))? $f->getCommander()->getId():null,
                'ownerId' => $f->getOwner()->getId(),
            ];
            $returns[] = $lf;
        }
        return $this->json($returns);
    }
    
    /**
     * 
     * @Route("/colony/{cid}/build", name="colony_build", requirements={"cid"="\d+"}, methods={"POST", "OPTIONS"})
     */
    public function build(Request $request, LoggerInterface $logger, $cid) {
        if($request->request->has('bid')) {
            $bid = intval($request->request->get('bid'));
            if(!empty($bid)
                && $request->request->has('_csrf')
                && $this->isCsrfTokenValid('colony-'.$cid.'-build-'.strval($bid), $request->request->get('_csrf'))) {
                $buildRepo = $this->getDoctrine()->getRepository(Building::class); /** @var BuildingRepository $buildRepo */
                $colony = $this->getDoctrine()->getRepository(Colony::class)->find($cid);
                $building = $buildRepo->find($bid);
                try {
                    // check again is can be built
                    if($buildRepo->canBuild($colony, $building)) {
                        if($this->getDoctrine()->getRepository(Building::class)->build($building, $colony)) {
                            $this->addMessage('ok', 'Lancement de la construction du bâtiment...', true);
                        } else {
                            $this->addMessage('error', 'Une erreur est survenue lors du lancement de la construction', true);
                        }
                    } else { // wait, that's illegal
                        $this->addMessage('error', 'Vous ne disposez pas des ressources suffisantes pour construire cela', true);
                    }
                } catch(Exception $e) {
                    $logger->error($e->getMessage());
                    $logger->error($e->getTraceAsString());
                    $this->addMessage('error', 'Une erreur est survenue lors du lancement de la construction', true);
                }
            } else {
                $this->addMessage('error', 'XSRF error', true);
            }
        } else {
            $this->addMessage('error', 'No building IG provided', true);
        }
        return $this->redirectToRoute('colony_details', [
            'cid' => $cid,
            '_fragment' => 'buildings-tabpane',
        ]);
    }
    
    /**
     * 
     * @Route("/colony/{cid}/search", name="colony_search", requirements={"cid"="\d+"}, methods={"POST", "OPTIONS"})
     */
    public function search(Request $request, LoggerInterface $logger, $cid) {
        if($request->request->has('tid')) {
            $tid = intval($request->request->get('tid'));
            if(!empty($tid)
                && $request->request->has('_csrf')
                && $this->isCsrfTokenValid('colony-'.$cid.'-search-'.strval($tid), $request->request->get('_csrf'))) {
                $techRepo = $this->getDoctrine()->getRepository(\App\Entity\Technology::class); /** @var \App\Repository\TechnologyRepository $techRepo */
                $colony = $this->getDoctrine()->getRepository(Colony::class)->find($cid);
                $research = $this->getDoctrine()->getRepository(\App\Entity\Research::class)->find($tid);
                try {
                    // check again is can be built
                    if($techRepo->canSearch($colony, $research)) {
                        if($techRepo->search($research, $colony)) {
                            $this->addMessage('ok', 'Lancement de la recherche de la technologie...', true);
                        } else {
                            $this->addMessage('error', 'Une erreur est survenue lors du lancement de la recherche', true);
                        }
                    } else { // wait, that's illegal
                        $this->addMessage('error', 'Vous ne disposez pas des ressources suffisantes pour rechercher cela', true);
                    }
                } catch(Exception $e) {
                    $logger->error($e->getMessage());
                    $logger->error($e->getTraceAsString());
                    $this->addMessage('error', 'Une erreur est survenue lors du lancement de la recherche', true);
                }
            } else {
                $this->addMessage('error', 'XSRF error', true);
            }
        } else {
            $this->addMessage('error', 'No research IG provided', true);
        }
        return $this->redirectToRoute('colony_details', [
            'cid' => $cid,
            '_fragment' => 'techs-tabpane',
        ]);
    }
}
