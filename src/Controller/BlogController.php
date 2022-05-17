<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
// use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


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

    #[Route('/blog/new', name: 'app_create')]
    #[Route('/blog/{id}/edit', name: 'app_edit')]
    public function form(Article $article = null, Request $request, EntityManagerInterface $manager): Response
    {

        // $article->setTitle("Titre de l'exemple")
        //         ->setContent("Contenu de l'article ...");

        if (!$article) {
            $article = new Article();
        }


        $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('content')
            ->add('image')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTimeImmutable());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('app_show', ['id' => $article->getId()]);
        }

        dump($article);

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }
}
