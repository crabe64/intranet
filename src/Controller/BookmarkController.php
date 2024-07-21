<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Form\BookmarkType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class BookmarkController extends AbstractController
{
    #[Route('/favoris/nouveau-favoris', name: 'bookmark_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookmark = new Bookmark();

        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $bookmark = $form->getData();
            $bookmark->setUser($this->getUser());
            $entityManager->persist($bookmark);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('bookmark/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
