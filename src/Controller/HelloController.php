<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getManager()->getRepository(Person::class);
        $data = $repository->findAll();
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'data' => $data,
        ]);
    }

    #[Route('/find/{id}', name: 'find')]
    public function find(Request $request, Person $person): Response
    {
        return $this->render('hello/find.html.twig', [
            'title' => 'Hello',
            'data' => $person,
        ]);
    }
}

class FindForm
{
    private $find;

    public function getFind()
    {
        return $this->find;
    }

    public function setFind($find)
    {
        $this->find = $find;
    }
}