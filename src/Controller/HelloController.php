<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{msg}', name: 'hello')]
    public function index($msg='hello!')
    {
        return $this->render('hello/index.html.twig', [
            'controller' => 'HelloController',
            'action' => 'index',
            'prev_action' => '(none)',
            'message' => $msg,
        ]);
    }

    #[Route('/other/{action}/{msg}', name: 'other')]
    public function other($action,$msg)
    {
        return $this->render('hello/index.html.twig', [
            'controller' => 'HelloController',
            'action' => 'other',
            'prev_action' => $action,
            'message' => $msg,
        ]);
    }
}