<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends GlobalController {
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer) {
        $params = [
            'email' => '',
            'username' => '',
        ];
        if($request->request->has('register')
                && $request->request->has('email')
                && $request->request->has('username')
                && $request->request->has('cgu')
                && $this->isCsrfTokenValid('user-register', $request->request->get('_csrf'))) {
            $params['email'] = $request->request->get('email');
            $params['username'] = $request->request->get('username');
            // check if none exists
            if($this->getDoctrine()->getRepository(User::class)->searchAnyEmailUsername($params['email'], $params['username'])) {
                $this->addMessage('error', 'Cet email et/ou cet identifiant d\'utilisateur est déjà utilisé !');
            } else {
                // generate random pwd
                // pwd are actually predictable, that may lead to issues if we got heavy traffic
                // that shouldn't be an issue at first, but we'll need to fix it if the game works well
                // @TODO
                $clearPwd = sha1(uniqid(uniqid(md5($params['username'])), true));
                // register
                $u = new User;
                $u->setAdmin(false);
                $u->setEmail($params['email']);
                $u->setMoney(0.00); // @TODO
                $u->setPwd($encoder->encodePassword($u, $clearPwd));
                $u->setStatus(User::STATUS_ACTIVE);
                $u->setUsername($params['username']);
                $this->getDoctrine()->getManager()->persist($u);
                $this->getDoctrine()->getManager()->flush();
                // mail
                $mailContent = (new \Swift_Message('Register'))
                        ->setFrom('lpu8er@lpu8er.com')
                        ->setTo($params['email'])
                        ->setBody($this->renderView('mails/register.html.twig', ['pwd' => $clearPwd,]));
                $mailer->send($mailContent);
                $this->addMessage('success', 'Inscription réalisée avec succès ! Vérifiez votre boite mail pour vous connecter une première fois.');
            }
        }
        return $this->render('external/register.html.twig', $params);
    }
    
    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu() {
        return $this->render('external/cgu.html.twig', []);
    }
    
    /**
     * @Route("/info", name="info")
     */
    public function info() {
        return $this->render('external/info.html.twig', []);
    }
}
