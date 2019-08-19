<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET", "PUT", "POST", "PATCH"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'Restricted access'
        ], 403);
        // return $this->json($data, $status = 200, $headers = [], $context = []);
    }

}
