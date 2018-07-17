<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends InternalController {
    /**
     * @Route("/home", name="home")
     */
    public function index() {
        if(!$this->isGranted('ROLE_VERIFIED')) {
            $returns = $this->redirectToRoute('character');
        } else {
            $returns = $this->render('internal/home.html.twig', []);
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
    public function createCharacter() {
        $mc = $this->getUser()->getMainCharacter();
        if(!empty($mc)) {
            $returns = $this->redirectToRoute('home');
        } else {
            $startSkillPoints = $this->getParameter('character.startskillpoints');
            $random = [
                'firstName' => $this->randomFirstName(),
                'lastName' => $this->randomLastName(),
                'givenName' => $this->randomGivenName(),
            ];
            $skills = $this->getDoctrine()->getRepository(\App\Entity\Skill::class)->findByUsableOnCharacter(true);
            $returns = $this->render('internal/character.html.twig', [
                'random' => $random,
                'skills' => $skills,
                'startSkillPoints' => $startSkillPoints,
            ]);
        }
        return $returns;
    }
    
    protected function randomFirstName(): string { return ''; }
    protected function randomLastName(): string { return ''; }
    protected function randomGivenName(): string { return ''; }
}
