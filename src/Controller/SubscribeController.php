<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SubscribeController extends Controller {
    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function index() {
        return $this->render('external/subscribe.html.twig', []);
    }
}
