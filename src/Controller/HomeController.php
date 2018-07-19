<?php
namespace App\Controller;

use App\Entity\Character;
use App\Entity\CharacterSkill;
use App\Entity\Colony;
use App\Entity\Fleet;
use App\Entity\Planet;
use App\Entity\Skill;
use DateInterval;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends InternalController {
    /**
     * @Route("/home", name="home")
     */
    public function index() {
        if(!$this->isGranted('ROLE_VERIFIED')
                && empty($this->getUser()->getMainCharacter())) {
            $returns = $this->redirectToRoute('character');
        } else {
            $colonies = $this->getDoctrine()->getRepository(Colony::class)->findByOwner($this->getUser());
            $fleets = $this->getDoctrine()->getRepository(Fleet::class)->findByOwner($this->getUser());
            
            $returns = $this->render('internal/home.html.twig', [
                'colonies' => $colonies,
                'fleets' => $fleets,
                'researchqueue' => [],
                'prodqueue' => [],
                'buildqueue' => [],
            ]);
        }
        return $returns;
    }
    
    /**
     * @Route("/preferences", name="preferences")
     */
    public function preferences(Request $request, UserPasswordEncoderInterface $encoder) {
        if($request->request->has('savePrefs')
                && $this->isCsrfTokenValid('user-preferences', $request->request->get('_csrf'))) {
            if($request->request->has('oldPwd')
                    && $request->request->has('newPwd')
                    && $request->request->has('newPwdBis')) {
                if($encoder->isPasswordValid($this->getUser(), $request->request->get('oldPwd'))
                        && ($request->request->get('newPwd') == $request->request->get('newPwdBis'))) {
                    // change it
                    $encoded = $encoder->encodePassword($this->getUser(), $request->request->get('newPwd'));
                    $this->getUser()->setPwd($encoded);
                    $this->getDoctrine()->getManager()->persist($this->getUser());
                    $this->getDoctrine()->getManager()->flush();
                    $this->addMessage('success', 'Le mot de passe a été changé avec succès !');
                } else {
                    $this->addMessage('error', 'Echec du changement de mot de passe : soit l\'ancien est incorrect, soit les deux nouveaux sont différents.');
                }
            }
        }
        return $this->render('internal/preferences.html.twig', []);
    }
    
    /**
     * @Route("/character", name="character")
     */
    public function createCharacter(Request $request) {
        $mc = $this->getUser()->getMainCharacter();
        if(!empty($mc)) {
            $returns = $this->redirectToRoute('home');
        } else {
            $startSkillPoints = $this->getParameter('character.startskillpoints');
            $skills = $this->getDoctrine()->getRepository(Skill::class)->findByUsableOnCharacter(true);
            if($request->request->has('createCharacter')
                    && $this->isCsrfTokenValid('user-character', $request->request->get('_csrf'))
                    && $request->request->has('lastName')
                    && $request->request->has('firstName')) {
                $c = new Character;
                $c->setBirthDate((new DateTime)->sub(new DateInterval('P20Y')));
                $c->setLvl(1);
                $c->setXp(0);
                $c->setHealth(100);
                $c->setStamina(100);
                $c->setIsMain(true);
                $c->setFirstName($request->request->get('firstName'));
                $c->setLastName($request->request->get('lastName'));
                $c->setGivenName($request->request->get('givenName', ''));
                $c->setGender(Character::GENDER_M); // @TODO
                $c->setRace(Character::RACE_HUMAN); // @TODO
                // if there is something fishy with skillpoints, let them at 0
                $c->setBaseSkillPoints($startSkillPoints);
                $usedSkills = $this->filterByAllowedSkills(array_map('intval', $request->request->get('skill')), $skills);
                $usedPoints = intval(array_sum($usedSkills));
                if($startSkillPoints < $usedPoints) {
                    $c->setUsedSkillPoints(0);
                    $usedSkills = [];
                    $this->addFlash('warn', 'Quelque chose d\'étrange a été détecté concernant les skillpoints, et leur choix a été remis à plus tard.');
                } else {
                    $c->setUsedSkillPoints($usedPoints);
                }
                $this->getDoctrine()->getManager()->persist($c);
                $this->getDoctrine()->getManager()->flush();
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
                    $colony->setCelestial($startPlanet);
                    $colony->setCtype(Colony::CTYPE_EARTH);
                    $colony->setLeader($c);
                    $colony->setName($startPlanet->getName());
                    $colony->setOwner($this->getUser());
                    $this->getDoctrine()->getManager()->persist($colony);
                    $this->getDoctrine()->getManager()->flush();
                } // no colony ? that shouldn't be possible @TODO
                $this->addFlash('success', 'Création du premier personnage bien effectué !');
                $returns = $this->redirectToRoute('home');
            } else {
                $random = [
                    'firstName' => $this->randomFirstName(),
                    'lastName' => $this->randomLastName(),
                    'givenName' => $this->randomGivenName(),
                ];
                $returns = $this->render('internal/character.html.twig', [
                    'random' => $random,
                    'skills' => $skills,
                    'startSkillPoints' => $startSkillPoints,
                ]);
            }
        }
        return $returns;
    }
    
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
    
    protected function randomFirstName(): string { return 'test1'; }
    protected function randomLastName(): string { return 'test2'; }
    protected function randomGivenName(): string { return 'test3'; }
}