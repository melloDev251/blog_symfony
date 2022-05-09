<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class BlogController extends AbstractController
{
    // public function __construct($articleRepository $article = null) {
    //     $this->article = $article;
    // }

    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $repo): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'title' => "Hello les amies",
            'age' => 12
        ]);
    }

    #[Route('/blog/article/{id}', name: 'app_show')]
    public function show(Article $article): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);

        // $article = $repo->find($id);

        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }
}
