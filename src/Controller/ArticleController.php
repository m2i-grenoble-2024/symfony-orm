<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/article')]
class ArticleController extends AbstractController
{

    public function __construct(
        private ArticleRepository $repo, 
        private EntityManagerInterface $em
    ){}

    #[Route(methods: 'GET')] 
    public function all(): JsonResponse
    {
        return $this->json(
            $this->repo->findAll()
        );
    }
    /**
     * Ici Symfony et Doctrine travaillent main dans la main et juste en indiquant l'id
     * en paramètre et le type d'entité à aller chercher et il feront le find automatiquement
     * et une erreur 404 si jamais pas de résultat
     */
    #[Route('/{id}', methods:'GET')]
    public function one(Article $article): JsonResponse {
       
        return $this->json($article);
    }
    /*
        #[Route('/{id}', methods:'GET')]
    public function one(int $id): JsonResponse {
        
        $article = $this->repo->find($id);
        //Si on a pas trouvé l'article pour cet id, on renvoie une erreur 404
        if(!$article) {
            throw new NotFoundHttpException("Article not found");
            
        }
        return $this->json($article);
    }
    */    
    #[Route(methods:'POST')]
    public function add(#[MapRequestPayload] Article $article): JsonResponse {
        //On assigne la date de maintenant en createdAt
        $article->setCreatedAt(new \DateTimeImmutable());
        $this->em->persist($article);
        $this->em->flush();
        return $this->json($article, 201);
    
    }

    #[Route('/{id}',methods:'DELETE')]
    public function delete(Article $article):JsonResponse {
        $this->em->remove($article);
        $this->em->flush();
        return $this->json(null, 204);
    }

    #[Route('/{id}', methods:'PUT')]
    public function update(Article $article, Request $request, SerializerInterface $serializer) {
        $serializer->deserialize($request->getContent(),Article::class,'json',
        [
            'object_to_populate' => $article
        ]);
        
        $this->em->flush();
        return $this->json($article);
    }

    #[Route('/{article}/category/{category}', methods: 'PATCH')]
    public function addCategory(Article $article, Category $category) {
        if($article->getCategories()->contains($category)) {
            $article->removeCategory($category);
        }else {
            $article->addCategory($category);
        }
        $this->em->flush();
        return $this->json($article);
    }

}
