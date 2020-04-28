<?php
namespace App\Controller;

use App\Entity\User;
use App\Utils\Random;
use App\Utils\REST;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SubscribeController extends GlobalController {
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, Swift_Mailer $mailer) {
        $params = [
            'email' => '',
            'username' => '',
            'recaptcha_public_key' => $this->getParameter('recaptcha.public_key'),
        ];
        if($request->request->has('register')
                && $request->request->has('email')
                && $request->request->has('username')
                && $request->request->has('cgu')
                && $this->isCsrfTokenValid('user-register', $request->request->get('_csrf'))
                && $request->request->has('g-recaptcha-response')) {
            
            $r = REST::jPost($this->getParameter('recaptcha.uri'), [
                'secret' => $this->getParameter('recaptcha.private_key'),
                'response' => strval($request->request->get('g-recaptcha-response')),
                'remoteip' => $request->getClientIp(),
            ]);
            
            if(empty($r['errors']) && !empty($r['response']) && $r['response']['success']) {
                $params['email'] = $request->request->get('email');
                $params['username'] = $request->request->get('username');
                // check if none exists
                if($this->getDoctrine()->getRepository(User::class)->searchAnyEmailUsername($params['email'], $params['username'])) {
                    $this->addMessage('error', 'Cet email et/ou cet identifiant d\'utilisateur est déjà utilisé !');
                } else {
                    $clearPwd = Random::factory()->pwd($params['username']);
                    // register
                    $this->getDoctrine()->getRepository(User::class)->createUser(
                            $params['username'],
                            $params['email'],
                            $clearPwd,
                            $encoder);
                    // mail
                    $mailContent = (new Swift_Message('Register'))
                            ->setFrom($this->getParameter('mail.register.sender'))
                            ->setTo($params['email'])
                            ->setBody($this->renderView('mails/register.html.twig', ['pwd' => $clearPwd,]));
                    $mailer->send($mailContent);
                    $this->addMessage('success', 'Inscription réalisée avec succès ! Vérifiez votre boite mail pour vous connecter une première fois.');
                }
            } else {
                $this->addMessage('error', 'Error while validating recaptcha');
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
    
    /**
     * @Route("/pwd", name="pwd")
     */
    public function pwd() {
        return $this->render('external/pwd.html.twig', []);
    }
}
