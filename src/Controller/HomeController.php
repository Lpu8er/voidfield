<?php
namespace App\Controller;

use App\Entity\Character;
use App\Entity\CharacterSkill;
use App\Entity\Colony;
use App\Entity\Fleet;
use App\Entity\Notification;
use App\Entity\Planet;
use App\Entity\Skill;
use App\Entity\User;
use App\Utils\TwigWrapper;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/ping", name="ping")
     */
    public function ping(Request $request) {
        $returns = [];
        $returns['now'] = microtime(true);
        if($request->request->has('mct')) {
            $returns['dif'] = $returns['now'] - floatval($request->request->get('mct'));
        }
        return new JsonResponse($returns);
    }
    
    /**
     * @Route("/preferences", name="preferences")
     */
    public function preferences(Request $request, UserPasswordEncoderInterface $encoder) {
        if($request->request->has('savePwd')
                && $this->isCsrfTokenValid('user-preferences-pwd', $request->request->get('_csrf'))) {
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
        if($request->request->has('savePrefs')
                && $this->isCsrfTokenValid('user-preferences', $request->request->get('_csrf'))) {
            $currentUser = $this->getUser(); /** @var User $currentUser */
            $currentUser->setParameter(User::PARAM_DATE_FORMAT, $request->request->get('dateFormat'));
            $currentUser->setParameter(User::PARAM_NOTIFY_TOASTR, $request->request->has('notifyToastr'));
            $currentUser->setParameter(User::PARAM_NOTIFY_AUTOREAD, $request->request->has('notifyAutoread'));
            $this->getDoctrine()->getManager()->persist($currentUser);
            $this->getDoctrine()->getManager()->flush();
            $this->addMessage('success', 'Modifications des préférences bien enregistrées !');
        }
        return $this->render('internal/preferences.html.twig', []);
    }
    
    /**
     * @Route("/character", name="character")
     */
    public function createCharacter(Request $request) {
        $mc = $this->getUser()->getMainCharacter();
        if(!empty($mc)) { // already got a main character
            $returns = $this->redirectToRoute('home');
        } else {
            $startSkillPoints = $this->getParameter('character.startskillpoints');
            $skills = $this->getDoctrine()->getRepository(Skill::class)->findByUsableOnCharacter(true);
            if($request->request->has('createCharacter')
                    && $this->isCsrfTokenValid('user-character', $request->request->get('_csrf'))
                    && $request->request->has('lastName')
                    && $request->request->has('firstName')) {
                // generate first character
                
                // if there is something fishy with skillpoints, let them at 0
                $usedSkillPoints = 0;
                $usedSkills = $this->filterByAllowedSkills(array_map('intval', $request->request->get('skill')), $skills);
                $usedPoints = intval(array_sum($usedSkills));
                if($startSkillPoints < $usedPoints) {
                    $usedSkills = [];
                    $this->addFlash('warn', 'Quelque chose d\'étrange a été détecté concernant les skillpoints, et leur choix a été remis à plus tard.');
                } else {
                    $usedSkillPoints = $usedPoints;
                }
                
                $c = $this->getDoctrine()->getManager()->getRepository(Character::class)->generateMain(
                        $request->request->get('firstName'),
                        $request->request->get('lastName'),
                        $request->request->get('givenName', ''),
                        $startSkillPoints,
                        $usedSkillPoints,
                        20,
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
    
    /**
     * @Route("/money", name="money")
     */
    public function money(Request $request) {
        $returns = [
            'money' => TwigWrapper::nformat($this->getUser()->getMoney()),
        ];
        return new JsonResponse($returns);
    }
    
    /**
     * @Route("/notifications", name="notifications")
     */
    public function notifications(Request $request) {
        $returns = [
            'messages' => [],
        ];
        $notifyRepo = $this->getDoctrine()->getRepository(Notification::class);
        $notifications = $notifyRepo->findBy([
            'date_notify' => null,
            'player' => $this->getUser()->getId(),
        ]);
        foreach($notifications as $n) { /** @var Notification $n */
            $returns['messages'][] = [
                'type' => $n->getNotifType(),
                'message' => htmlspecialchars($n->getContent()),
                'when' => $n->getDateSent(),
                'id' => $n->getId(),
            ];
            // mark as notified
            $n->setDateNotify(new DateTime);
            $this->getDoctrine()->getManager()->persist($n);
        }
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($returns);
    }
}
