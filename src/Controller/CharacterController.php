<?php
namespace App\Controller;

use App\Entity\Character;
use App\Entity\CharacterSkill;
use App\Entity\Colony;
use App\Entity\Planet;
use App\Entity\Skill;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of CharacterController
 *
 * @author lpu8er
 * @Route("/character")
 */
class CharacterController extends InternalController {
    /**
     * @Route("", name="character")
     */
    public function index(Request $request) {
        $mc = $this->getUser()->getMainCharacter();
        if(empty($mc)) {
            $returns = $this->createCharacter($request);
        } else {
            
        }
        return $returns;
    }
    
    public function createCharacter(Request $request) {
        $startSkillPoints = $this->getParameter('character.startskillpoints');
        $skills = $this->getDoctrine()->getRepository(Skill::class)->findByUsableOnCharacter(true);
        if($this->isCsrfTokenValid('user-character', $request->request->get('_csrf'))
                && $request->request->has('lastName')
                && $request->request->has('firstName')) {
            // generate first character

            // if there is something fishy with skillpoints, let them at 0
            $usedSkillPoints = 0;
            $usedSkills = $this->filterByAllowedSkills(array_map('intval', $request->request->get('skills')), $skills);
            $usedPoints = intval(array_sum($usedSkills));
            if($startSkillPoints < $usedPoints) {
                $usedSkills = [];
                $this->addMessage(
                    'warn',
                    'Quelque chose d\'étrange a été détecté concernant les skillpoints, et leur choix a été remis à plus tard.',
                    true
                );
            } else {
                $usedSkillPoints = $usedPoints;
            }

            $charRepo = $this->getDoctrine()->getManager()->getRepository(Character::class); /** @var \App\Repository\CharacterRepository $charRepo */
            $c = $charRepo->generateMain(
                    $request->request->get('firstName'),
                    $request->request->get('lastName'),
                    $request->request->get('givenName', '')?? '',
                    $startSkillPoints,
                    $usedSkillPoints,
                    20, // age
                    Character::GENDER_M,
                    Character::RACE_HUMAN);

            // inject skills
            foreach($usedSkills as $sk => $sv) {
                $cs = new CharacterSkill;
                $cs->setCharacter($c);
                $cs->setSkill($this->getDoctrine()->getRepository(Skill::class)->find($sk));
                $cs->setPoints($sv);
                $this->getDoctrine()->getManager()->persist($cs);
                $this->getDoctrine()->getManager()->flush();
            }
            // update main
            $this->getUser()->setMainCharacter($c);
            $this->getDoctrine()->getManager()->persist($this->getUser());
            $this->getDoctrine()->getManager()->flush();
            // create colony on a start planet randomly at first
            $startPlanets = $this->getDoctrine()->getRepository(Planet::class)->findByStartable(true);
            if(!empty($startPlanets)) {
                $startPlanet = $startPlanets[0];
                $colony = new Colony;
                $colony->setPopulation($this->getParameter('colony.startpop'));
                $colony->setCelestial($startPlanet);
                $colony->setCtype(Colony::CTYPE_EARTH);
                $colony->setLeader($c);
                $colony->setName($startPlanet->getName());
                $colony->setOwner($this->getUser());
                $this->getDoctrine()->getManager()->persist($colony);
                $this->getDoctrine()->getManager()->flush();
            } // no colony ? that shouldn't be possible @TODO
            $this->addMessage('success',
                'Création du premier personnage bien effectué !',
                true
            );
            $returns = $this->redirectToRoute('character'); // refresh by redirect
        } else {
            $random = [
                'firstName' => $this->randomFirstName(),
                'lastName' => $this->randomLastName(),
                'givenName' => $this->randomGivenName(),
            ];
            $returns = $this->render('internal/character/create.html.twig', [
                'random' => $random,
                'skills' => $skills,
                'startSkillPoints' => $startSkillPoints,
            ]);
        }
        return $returns;
    }
    
    protected function randomFirstName(): string { return 'test1'; }
    protected function randomLastName(): string { return 'test2'; }
    protected function randomGivenName(): string { return 'test3'; }
    
    /**
     * Doctrine has the wrong taste to give us unordered collection
     * @param array $usedSkills
     * @param Skill[] $usableSkills
     * @return array
     */
    protected function filterByAllowedSkills($usedSkills, $usableSkills) {
        foreach($usedSkills as $k => $v) {
            $f = false;
            foreach($usableSkills as $e) {
                if($e->getId() === $k) { $f = true; }
            }
            if(!$f) { $usedSkills[$k] = 0; } // remove
        }
        return $usedSkills;
    }
}
