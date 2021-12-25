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
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'message' => 'あなたのお名前:',
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