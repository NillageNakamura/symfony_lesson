<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(Request $request)
    {
        if ($request->getMethod() == 'POST'){
            $input = $request->request->get('input');
            $msg = 'こんにちわ' . $input . 'さん';
        } else {
            $msg = 'お名前は？';
        }
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'message' => $msg,
        ]);
    }

    #[Route('/other', name: 'other')]
    public function other(Request $request)
    {
        $input = $request->request->get('input');
        $msg = 'こんにちわ' . $input . 'さん';
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello!!!',
            'message' => $msg,
        ]);
    }
}