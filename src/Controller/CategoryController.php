<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/category')]
class CategoryController extends AbstractController
{

    public function __construct(
        private CategoryRepository $repo,
        private EntityManagerInterface $em
    ){}

    #[Route(methods:'GET')]
    public function all() {
        return $this->json(
            $this->repo->findAll()
        );
    }

    #[Route(methods:'POST')]
    public function add(#[MapRequestPayload] Category $category) {
        $this->em->persist($category);
        $this->em->flush();
        return $this->json($category, 201);
    }

    #[Route('/{id}/articles', methods:'GET')]
    public function articlesOfCategory(Category $category) {
        return $this->json(
            $category->getArticles()
        );
    }
}
