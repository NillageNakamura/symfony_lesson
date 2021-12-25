<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    #[Route('/hello', name: 'hello')]
    public function index()
    {
        return new Response('hello symfony!!');
    }
}