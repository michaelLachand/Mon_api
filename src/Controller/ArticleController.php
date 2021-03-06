<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'article_create', methods: ['POST'])]
    public function createArticle(Request $request,SerializerInterface $serializer,EntityManagerInterface $em): Response
    {
        $data = $request->getContent();
        $author = $serializer->deserialize($data, Article::class, 'json');

        $em->persist($author);
        $em->flush();

        return new Response('',Response::HTTP_CREATED);

    }

    #[Route('/articles/{id}', name: 'article_show', methods: ['GET'])]
    public function showArticle(Article $article,SerializerInterface $serializer)
    {
        $data = $serializer->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

}
