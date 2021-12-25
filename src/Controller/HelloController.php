<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(Request $request, SessionInterface $session)
    {
        $data = new MyData();
        $form = $this->createFormBuilder($data)
            ->add('data', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Click'])
            ->getForm();

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            $data = $form->getData();
            if ($data->getData() == '!'){
                $session->remove('data');
            } else {
                $session->set('data', $data->getData());
            }
        }

        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'data' => $session->get('data'),
            'form' => $form->createView(),
        ]);
    }
}
class Mydata
{
    protected $data = '';

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}
