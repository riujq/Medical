<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/article', name: 'admin_article_')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArticleRepository $ArticleRepo):Response
    {
        $articles=$ArticleRepo->findby([],['id'=>'asc']);
        return $this->render('admin/article.html.twig',compact('articles'));
    }
    #[Route('/new', name: 'create')]
    #[Route('/edit/{id}', name: 'edit')]
    public function Form(?Article $article,Request $request, ManagerRegistry $manager): Response
    {  
        $article = $article ? $article : new article();
        $Form=$this->CreateForm(ArticleType::class,$article);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {          
            $em=$manager->getManager();
            if(!$article->getCreatedAt()){$article->setCreatedAt(new \DateTime());}
            $em->persist($article);
            $em->Flush();
            return $this->redirectToRoute('admin_article_index');
        }
        return $this->render('admin/index.html.twig',  ['form' => $Form->createView()]);
    }  
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Article $article,ManagerRegistry $manager): Response
    {            
        $em=$manager->getManager();
        $em->remove($article);
        $em->Flush();        
        $this->addFlash('info',"L'article a été supprimé avec succès");
        return $this->redirectToRoute('admin_article_index');
    } 
}