<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(Request $request)
    {
        $name = $request->get('name');
        $pass = $request->get('pass');

        $result = '<html><body>';
        $result .= '<h1>Parameter</h1>';
        $result .= '<p>name: ' . $name . '</p>';
        $result .= '<p>pass: ' . $pass . '</p>';
        $result .= '</body></html>';
        return new Response($result);
    }
}