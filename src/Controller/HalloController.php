<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HalloController extends Controller
{
    /**
     * @Route("/hallo", name="hallo", methods={"GET"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller! Get',
            'path' => 'src/Controller/HalloController.php',
        ]);
 
        // the shortcut defines three optional arguments
        // return $this->json($data, $status = 200, $headers = [], $context = []);
    }
    /**
     * @Route("/hallo", name="create", methods={"POST"})
     */
    public function create()
    {
        return $this->json([
            'message' => 'Welcome to your new controller! POST',
            'path' => 'src/Controller/HalloController.php',
        ]);
    }

}
