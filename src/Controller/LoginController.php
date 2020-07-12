<?php
namespace App\Controller;

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
            'error' => null,
            'user' => null,
        ];
        
        $user = $this->getUser();
        if(!empty($user)) {
            $returns['user'] = [
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
            ];
        } else {
            $returns['error'] = $authenticationUtils->getLastAuthenticationError();
        }

        return $this->json($returns);
    }
}
