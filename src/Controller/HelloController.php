<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index()
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
        ]);
    }

    #[Route('/other/{domain}', name: 'other')]
    public function other(Request $request, $domain='')
    {
        if ($domain == ''){
            return $this->redirect('/hello');
        }else{
            return new RedirectResponse("http://{$domain}.com");
        }
    }
}