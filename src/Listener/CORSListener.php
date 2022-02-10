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
        $m = strtolower(trim($event->getRequest()->getMethod()));
        if('options' === $m) { // if request is a CORS preflight, don't output 401 ! It would fail. options is still 200
            $event->getResponse()->setStatusCode(Response::HTTP_OK);
        }
        if(302 === $event->getResponse()->getStatusCode()) {
            // we have a login redirection; if we are in JSON, we'll need to output a single 401 redirect.
            // if not, we'll continue to output "normal" response
            if($this->isJson($event->getRequest())) {
                $event->getResponse()->setStatusCode(Response::HTTP_UNAUTHORIZED);
            }
        }
    }
    
    public function onKernelRequest(\Symfony\Component\HttpKernel\Event\RequestEvent $event) {
        $request = $event->getRequest();
        $content = $request->getContent();
        if(empty($request->request->keys()) && $this->isJson($request)) { // we are JSON typed, with no data ? transform it.
            $jsonData = json_decode($content, true);
            if(!empty($jsonData) && !json_last_error()) {
                $request->request->replace($jsonData);
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
