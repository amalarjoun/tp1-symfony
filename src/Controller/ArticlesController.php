<?php

namespace App\Controller;

use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;

class ArticlesController extends AbstractController
{
   #[Route('/articles/nouveau', name: 'app_article_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();

    // Créer le formulaire
        $form = $this->createForm(ArticleType::class, $article);

    // Traiter les données envoyées
        $form->handleRequest($request);

    // Vérifier si le formulaire est envoyé et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article créé avec succès !');

            return $this->redirectToRoute('app_articles');
    }

    // Afficher le formulaire
    return $this->render('articles/nouveau.html.twig', [
        'formulaire' => $form,
    ]);
}

    
    #[Route('/articles', name: 'app_articles')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/articles/{id}', name: 'app_article_detail', requirements: ['id' => '\d+'])]
    public function detail(Article $article): Response
    {
    return $this->render('articles/detail.html.twig', [
        'article' => $article,
    ]);
}
}