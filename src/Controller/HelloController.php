<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    #[Route('/find', name: 'find')]
    public function find(Request $request, ManagerRegistry $doctrine): Response
    {
        $formobj = new FindForm();
        $form = $this->createFormBuilder($formobj)
            ->add('find', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Click'])
            ->getForm();
        $repository = $doctrine->getRepository(Person::class);

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $findstr = $form->getData()->getFind();
            $result = $repository->findByNameOrMail($findstr);
        }else{
            $result = $repository->findAllWithSort();
        }

        return $this->render('hello/find.html.twig', [
            'title' => 'Hello',
            'data' => $result,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            $person = $form->getData();
            $errors = $validator->validate($person);

            if (count($errors) == 0) {
                $manager = $doctrine->getManager();
                $manager->persist($person);
                $manager->flush();
                return $this->redirect('/hello');
            } else {
                return $this->render('hello/hello.html.twig', [
                    'title' => 'Hello',
                    'message' => 'ERROR!',
                    'form' => $form->createView(),
                ]);
            }
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
