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
     * @Route("/colonies", name="colonies_list")
     */
    public function index() {
        $returns = [];
        return new JsonResponse($returns);
    }
    
    /**
     * @Route("/colony/{cid}", name="colony_detail", requirements={"cid"="\d+"})
     */
    public function detail(Request $request, $cid) {
        $returns = null;
        $colRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $colRepo */
        $colony = $colRepo->find($cid); /** @var Colony $colony */
        if(!empty($colony) && ($this->getUser()->getId() === $colony->getOwner()->getId())) {
            $extractors = [];
            $bExtractors = $this->getDoctrine()->getRepository(ColonyExtraction::class)->findBy(['colony' => $colony->getId(),]);
            foreach($bExtractors as $bExtractor) { /** @var ColonyExtraction $bExtractor */
                if(!array_key_exists($bExtractor->getResource()->getId(), $extractors)) {
                    $extractors[$bExtractor->getResource()->getId()] = [
                        'resource' => $bExtractor->getResource(),
                        'extractors' => [],
                        'natural' => null,
                    ];
                    try {
                        $extractors[$bExtractor->getResource()->getId()]['natural'] = $this->getDoctrine()->getRepository(Natural::class)->findOneBy([
                            'celestial' => $colony->getCelestial()->getId(),
                            'resource' => $bExtractor->getResource()->getId(),
                        ]);
                    } catch (Exception $ex) { } // just don't import it.
                }
            }
            
            $returns = $this->sr('colonies/detail', [
                    'colony' => $colony,
                    'stocks' => $colRepo->getPaddedResources($colony),
                    'buildable' => $this->getDoctrine()->getRepository(Building::class)->visibleList($colony),
                    'extractors' => $extractors,
                    'productors' => $this->getDoctrine()->getRepository(ColonyProduction::class)->findBy(['colony' => $colony->getId(),]),
                    'hasSpaceport' => $colRepo->hasSpaceport($colony),
                    'hasSpacefactory' => $colRepo->hasSpacefactory($colony),
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
                $buildRepo = $this->getDoctrine()->getRepository(Building::class); /** @var BuildingRepository $buildRepo */
                $colRepo = $this->getDoctrine()->getRepository(Colony::class); /** @var ColonyRepository $colRepo */
                $colony = $colRepo->find($cid);
                $building = $buildRepo->find($bid);
                try {
                    $colRepo->changeRunningBuilding($colony, $building, min(100, max(0, intval($request->request->get('val', 0)))));
                    $this->addMessage('ok', 'Changement de l\'activation du bâtiment...', true);
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
