<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{   
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $categories = $this->repoCategory->findAll();
        $articles = $this->repoArticle->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "articles" => $articles,
            "categories" => $categories
        ]);
    }

    /**
     * @Route("/showArticles/{id}", name="show_articles")
     */
    public function showArticles(?Category $category): Response
    {
        if ($category) {
            $articles = $category->getArticles()->getValues();
        } else {
            return $this->redirectToRoute("home");
        }
        return $this->render('home/index.html.twig', [
            "articles" => $articles,
            "categories" => $this->repoCategory->findAll()
        ]);
    }

    public function __construct(ArticleRepository $repoArticle, CategoryRepository $repoCategory)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
    }
    /**
     * @Route("/", name="home")
     */
    public function Article(ArticleRepository $repoArticle): Response
    {
        $articles = $repoArticle->findAll();
        return $this->render('home/index.html.twig', [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    // public function show(ArticleRepository $repoArticle, $id): Response
    // {
    //     $article = $repoArticle->find($id);
    //     if (!$article) {
    //         $this->redirectToRoute("home");
    //     }
    //     return $this->render('show/index.html.twig', [
    //         "article" => $article
    //     ]);
    // }
    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(ArticleRepository $repoArticle, $id): Response
    {
        $article = $repoArticle->find($id);
        if (!$article) {
            $this->redirectToRoute("home");
        }
        return $this->render('show/index.html.twig', [
            "article" => $article
        ]);
    }

}
