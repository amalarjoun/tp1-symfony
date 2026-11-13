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
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ArticlesController extends AbstractController
{
   #[Route('/articles/nouveau', name: 'app_article_nouveau')]
    #[IsGranted('ROLE_USER')]

    public function nouveau(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();
        $article->setAuteurUser($this->getUser());

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
#[Route('/articles/{id}/modifier', name: 'app_article_modifier', requirements: ['id' => '\d+'])]
public function modifier(Article $article, Request $request, EntityManagerInterface $em): Response
{
    if (
        $this->getUser() !== $article->getAuteurUser()
        && !$this->isGranted('ROLE_ADMIN')
    ) {
        throw $this->createAccessDeniedException(
            "Vous n'êtes pas l'auteur de cet article !"
        );
    }
    $form = $this->createForm(ArticleType::class, $article);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        $this->addFlash('success', 'Article modifié avec succès !');

        return $this->redirectToRoute('app_article_detail', [
            'id' => $article->getId()
        ]);
    }

    return $this->render('articles/modifier.html.twig', [
        'formulaire' => $form,
        'article' => $article,
    ]);
}
#[Route('/articles/{id}/supprimer', name: 'app_article_supprimer', requirements: ['id' => '\d+'], methods: ['POST'])]
public function supprimer(Article $article, Request $request, EntityManagerInterface $em): Response
{
    if ($this->isCsrfTokenValid(
        'supprimer_'.$article->getId(),
        $request->request->get('_token')
    )) {
        $em->remove($article);
        $em->flush();

        $this->addFlash('success', 'Article supprimé avec succès !');
    } else {
        $this->addFlash('danger', 'Token CSRF invalide.');
    }

    return $this->redirectToRoute('app_articles');
}
}