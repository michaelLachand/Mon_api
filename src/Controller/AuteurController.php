<?php

namespace App\Controller;

use App\Entity\Auteur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuteurController extends AbstractController
{

    #[Route('/auteurs', name: 'author_create', methods: ['POST'])]
    public function createAuthor(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        $data = $request->getContent();
        $author = $serializer->deserialize($data, Auteur::class, 'json');

        $em->persist($author);
        $em->flush();

        return new Response('',Response::HTTP_CREATED);
    }


    #[Route('/auteur/{id}', name: 'auteur', methods: ['GET'])]
    public function showAuthor(Auteur $author,SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}
