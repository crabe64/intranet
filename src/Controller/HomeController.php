<?php

namespace App\Controller;

use App\Repository\BookmarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'bookmarks' => $bookmarkRepository->findBy([], ['label' => 'ASC']),
        ]);
    }
}
