<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SubscribeController extends Controller
{
    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function index() {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SubscribeController.php',
        ]);
    }
}
