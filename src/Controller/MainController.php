<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Message;
use App\Form\ChatType;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ChatRepository $chats, Request $request, EntityManagerInterface $entMngr): Response{
        $myChats = $chats->getUserChats($this -> getUser());
        $activeChats = $chats->getActiveChats($this -> getUser());
        $newChat = new Chat();

        $form = $this -> createForm(ChatType::class, $newChat);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            if(trim($form -> get('title') -> getData()) != ''){
                $newChat -> setTitle($form -> get('title') -> getData());
            }
            else{
                $newChat -> setTitle('New chat');
            }
            
            $newChat -> addListUser($this -> getUser());

            $entMngr -> persist($newChat);
            $entMngr -> flush();

            return $this->redirectToRoute('app_chat_show', ['id' => $newChat -> getId()]);
        }
        
        return $this->render("main/index.html.twig",[
            'form' => $form, "myChats" => $myChats, 'active' => $activeChats,
        ]);
    }

    #[Route('/new', name: 'new_coment',)]
    public function newComent(Request $request , EntityManagerInterface $entityManagerInterface): Response
    {
       $messages = new Message();
       $messages->setAuthor($this->getUser()) ;
       $messages->setText($request->request->get('message')) ;
       $entityManagerInterface->persist($messages);
       $entityManagerInterface->flush();

       return $this->redirectToRoute('app_main');
    }
}
