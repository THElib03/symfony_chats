<?php

namespace App\Controller;

use App\Entity\Message;
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
    public function index(ChatRepository $chats): Response
    {
        //
        $Allchats = $chats->findAll();
        return $this->render("main/index.html.twig",[
            "chats" => $Allchats,
        ]);
    }


}
