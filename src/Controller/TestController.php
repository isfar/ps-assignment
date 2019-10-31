<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    private $config;

    public function __construct($validator)
    {
        $this->config = $validator;
    }
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        dump($this->config);
        
        die();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
