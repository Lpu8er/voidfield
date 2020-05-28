<?php
namespace App\Controller;

use App\Entity\WsToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of WebsockController
 *
 * @Route("/ws")
 * @author lpu8er
 */
class WebsockController extends InternalController {
    /**
     * @Route("/auth", name="wsauth")
     */
    public function auth(Request $request) {
        $returns = [];
        $status = 400;
        if($this->isGranted('ROLE_VERIFIED')) { // only
            $wsToken = $this->getDoctrine()->getRepository(WsToken::class)->auth($request, $this->getUser());
            if(!empty($wsToken)) {
                $returns['token'] = $wsToken->getToken();
                $status = 401;
            } else { // no suitable token
                $status = 403;
            }
        }
        return new JsonResponse($returns, $status, $headers);
    }
}
