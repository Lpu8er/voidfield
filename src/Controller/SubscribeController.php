<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SubscribeController extends Controller {
    /**
     * @Route("/register", name="register")
     */
    public function index() {
        return $this->render('external/register.html.twig', []);
    }
}
