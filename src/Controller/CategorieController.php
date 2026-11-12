<?php
namespace App\Controller;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategorieType;
class CategorieController extends AbstractController
{
#[Route('/categories', name: 'app_categories')]
public function index(CategorieRepository $categorieRepository): Response
{
$categories = $categorieRepository->findAll();
return $this->render('categorie/index.html.twig', [
'categories' => $categories,
]);
}
#[Route('/categories/nouvelle', name: 'app_categorie_nouvelle')]
public function nouvelle(
    Request $request,
    EntityManagerInterface $em
): Response {
    $categorie = new Categorie();

    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($categorie);
        $em->flush();

        $this->addFlash('success', 'Catégorie ajoutée avec succès !');

        return $this->redirectToRoute('app_categories');
    }

    return $this->render('categorie/nouvelle.html.twig', [
        'formulaire' => $form,
    ]);
}
    #[Route('/categories/{id}/modifier', name: 'app_categorie_modifier')]
    public function modifier(
        Categorie $categorie,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Catégorie modifiée avec succès !');

            return $this->redirectToRoute('app_categories');
        }

        return $this->render('categorie/modifier.html.twig', [
            'formulaire' => $form,
            'categorie' => $categorie,
        ]);
    }
    #[Route('/categories/{id}/supprimer', name: 'app_categorie_supprimer', methods: ['POST'])]
    public function supprimer(
        Categorie $categorie,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid(
            'supprimer_'.$categorie->getId(),
            $request->request->get('_token')
        )) {
            if (!$categorie->getArticles()->isEmpty()) {
                $this->addFlash(
                    'danger',
                    'Impossible de supprimer cette catégorie : elle contient des articles.'
                );

                return $this->redirectToRoute('app_categories');
            }
            $em->remove($categorie);
            $em->flush();

            $this->addFlash('success', 'Catégorie supprimée avec succès !');
        } else {
            $this->addFlash('danger', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_categories');
    }
}