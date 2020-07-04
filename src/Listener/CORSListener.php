<?php
namespace App\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Description of CORSListener
 *
 * @author lpu8er
 */
class CORSListener {
    /**
     *
     * @var string
     */
    protected $acceptedOrigins = null;
    
    /**
     * 
     * @param string $origin
     */
    public function __construct(string $origin) {
        $this->acceptedOrigins = $origin;
    }
    
    /**
     * 
     * @param ResponseEvent $event
     */
    public function onKernelResponse(ResponseEvent $event) {
        $responseHeaders = $event->getResponse()->headers;
        $responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
        $responseHeaders->set('Access-Control-Allow-Origin', $this->acceptedOrigins);
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        $responseHeaders->set('Access-Control-Allow-Credentials', 'true');
        if(302 === $event->getResponse()->getStatusCode()) {
            // we have a login redirection; if we are in JSON, we'll need to output a single 401 redirect.
            // if not, we'll continue to output "normal" response
            // in both case, send also CORS headers
            // if request is a CORS preflight, don't output 401 ! It would fail.
            $m = strtolower(trim($event->getRequest()->getMethod()));
            if('options' === $m) { // options is still 200
                $event->getResponse()->setStatusCode(Response::HTTP_OK);
            } elseif($this->isJson($event->getRequest())) {
                $event->getResponse()->setStatusCode(Response::HTTP_UNAUTHORIZED);
            }
        }
    }
    
    /**
     * 
     * @param Request $request
     * @return bool
     */
    protected function isJson(Request $request): bool {
        $ct = $request->getContentType();
        $returns = false;
        if(!empty($ct)) {
            $returns = ('json' === strtolower($ct));
        } elseif($request->headers->has('accept')) {
            $returns = (0 === stripos(trim($request->headers->get('accept')), 'application/json'));
        }
        return $returns;
    }
}
