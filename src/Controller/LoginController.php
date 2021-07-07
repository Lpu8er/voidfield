<?php
namespace App\Controller;

use App\Entity\CCredit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Description of LoginController
 *
 * @author lpu8er
 */
class LoginController extends GlobalController {
    /**
     * @Route("/", name="root")
     */
    public function index() {
        return $this->render('external/index.html.twig', []);
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils) {
        $returns = [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'name' => $authenticationUtils->getLastUsername(),
        ];
        if($returns['error']) {
            $this->addMessage('error', $returns['error']);
        }
        return $this->render('external/login.html.twig', $returns);
    }
    
    /**
     * @Route("/credits", name="credits")
     */
    public function credits() {
        return $this->render('external/credits.html.twig', []);
    }
}
