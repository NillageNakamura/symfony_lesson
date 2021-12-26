<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'message')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getManager()->getRepository(Message::class);
        $data = $repository->findAll();
        return $this->render('message/index.html.twig', [
            'title' => 'Message',
            'data' => $data,
        ]);
    }

    #[Route('message/create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            $message = $form->getData();
            $errors = $validator->validate($message);

            if (count($errors) == 0) {
                $manager = $doctrine->getManager();
                $manager->persist($message);
                $manager->flush();
                return $this->redirect('/message');
            } else {
                $msg = "oh...can't posted...";
            }
        } else {
            $msg = 'type your message!';
        }
        return $this->render('message/create.html.twig', [
            'title' => 'Hello',
            'message' => $msg,
            'form' => $form->createView(),
        ]);
    }
}
