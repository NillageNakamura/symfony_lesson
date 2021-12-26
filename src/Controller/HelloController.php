<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function find(Person $person, $id=1): Response
    {
        return $this->render('hello/find.html.twig', [
            'title' => 'Hello',
            'data' => $person,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        // リクエスト情報をフォームにハンドリング
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            // createFormBuilderに引数を指定しておくとgetDataでインスタンスを取り出せる
            $person = $form->getData();
            // マネージャを取得し、persistを使ってインスタンスを保存
            $manager = $doctrine->getManager();
            $manager->persist($person);
            // flushで反映
            $manager->flush();
            return $this->redirect('/hello');
        } else {
            return $this->render('hello/create.html.twig', [
                'title' => 'Hello',
                'message' => 'Create Entity',
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, ManagerRegistry $doctrine, Person $person, $id=1)
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            $person = $form->getData();
            $manager = $doctrine->getManager();
            $manager->persist($person);
            $manager->flush();
            return $this->redirect('/hello');
        } else {
            return $this->render('hello/create.html.twig', [
                'title' => 'Hello',
                'message' => 'Update Entity id=' . $person->getId(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Request $request, ManagerRegistry $doctrine, Person $person, $id=1)
    {
        $form = $this->createFormBuilder($person)
            ->add('save', SubmitType::class, ['label' => 'Delete'])
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $person = $form->getData();
            $manager = $doctrine->getManager();
            $manager->remove($person);
            $manager->flush();
            return $this->redirect('/hello');
        } else {
            return $this->render('hello/delete.html.twig', [
                'title' => 'Hello',
                'message' => 'Delete Entity id=' . $person->getId(),
                'form' => $form->createView(),
                'data' => $person,
            ]);
        }
    }
}
