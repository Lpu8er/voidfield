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
            
            $returns = $this->sr('home', [
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
        $returns['on'] = !empty($this->getUser());
        if($returns['on']) {
            $returns['who'] = [
                'id' => $this->getUser()->getId(),
                'username' => $this->getUser()->getUsername(),
                'money' => $this->getUser()->getMoney(),
                'roles' => $this->getUser()->getRoles(),
            ];
        }
        return $this->json($returns);
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
        return $this->sr('preferences');
    }
    
    /**
     * @Route("/money", name="money")
     */
    public function money(Request $request) {
        $returns = [
            'money' => TwigWrapper::nformat($this->getUser()->getMoney()),
        ];
        return $this->json($returns);
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
        return $this->json($returns);
    }
}
