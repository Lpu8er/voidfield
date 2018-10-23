<?php
namespace App\Controller;

use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Utils\REST;

class SubscribeController extends GlobalController {
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, Swift_Mailer $mailer) {
        $params = [
            'email' => '',
            'username' => '',
        ];
        if($request->request->has('register')
                && $request->request->has('email')
                && $request->request->has('username')
                && $request->request->has('cgu')
                && $this->isCsrfTokenValid('user-register', $request->request->get('_csrf'))
                && $request->request->has('g-recaptcha-response')) {
            
            $r = REST::jPost($this->getParameter('recaptcha.uri'), [
                'secret' => $this->getParameter('recaptcha.key'),
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
