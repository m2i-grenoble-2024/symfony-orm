<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/comment')]
class CommentController extends AbstractController
{
    public function __construct(
        private CommentRepository $repo, 
        private EntityManagerInterface $em
    ) {}

    #[Route('/article/{id}', methods: 'GET')]
    public function commentsOfArticle(Article $article) {
        // return $this->json(
        //     $this->repo->findBy([
        //         'article' => $article
        //     ])
        // );
        return $this->json(
            $article->getComments()
        );
    }
}
