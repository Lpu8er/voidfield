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
     * @Route("/colonies", name="my_colonies", methods={"GET", "OPTIONS"})
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
     * @Route("/colonies/{cid}/res", name="my_colony_resources", methods={"GET", "OPTIONS"}, requirements={"cid"="\d+"})
     */
    public function resources(Request $request, $cid) {
        $returns = [];
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony)
                && !empty($colony->getOwner())
                && ($colony->getOwner()->getId() == $this->getUser()->getId())) {
            $stocks = $colony->getStocks();
            foreach($stocks as $s) {
                $returns[] = [
                    'resource' => $s->getResource(),
                    'nb' => $s->getStocks(),
                ];
            }
        } else {
            $returnCode = JsonResponse::HTTP_NOT_FOUND;
        }
        return $this->json($returns, $returnCode);
    }
    
    /**
     * @Route("/colonies/{cid}", name="my_colony_details", methods={"GET", "OPTIONS"}, requirements={"cid"="\d+"})
     */
    public function detail(Request $request, $cid) {
        $returns = null;
        $returnCode = JsonResponse::HTTP_OK;
        $coloRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $coloRepo */
        $colony = $coloRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony)
                && !empty($colony->getOwner())
                && ($colony->getOwner()->getId() == $this->getUser()->getId())) {
            $returns = $colony;
        } else {
            $returnCode = JsonResponse::HTTP_NOT_FOUND;
        }
        return $this->json($returns, $returnCode);
    }
    
    /**
     * @Route("/colonies/{cid}/buildings", name="my_colony_buildings", methods={"GET", "OPTIONS"}, requirements={"cid"="\d+"})
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
     * @Route("/colonies/{cid}/bqueue", name="my_colony_building_queue", methods={"GET", "OPTIONS"}, requirements={"cid"="\d+"})
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
     * @Route("/colonies/{cid}/buildable", name="my_colony_buildable", methods={"GET", "OPTIONS"}, requirements={"cid"="\d+"})
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
     * @Route("/colonies/{cid}/fleets", name="my_colony_fleets", methods={"GET", "OPTIONS"}, requirements={"cid"="\d+"})
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
                $colony = $this->getDoctrine()->getRepository(Colony::class)->find($cid);
                $building = $this->getDoctrine()->getRepository(Building::class)->find($bid);
                try {
                    if($this->getDoctrine()->getRepository(Building::class)->build($building, $colony)) {
                        $this->addMessage('ok', 'Lancement de la construction du bâtiment...', true);
                    } else {
                        $this->addMessage('error', 'Une erreur est survenue lors du lancement de la construction', true);
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
        return $this->redirectToRoute('colony_detail', [
            'cid' => $cid,
            '_fragment' => 'buildings-tabpane',
        ]);
    }
}
