<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_home')]
    public function index(ArticleRepository $ArticleRepo): Response
    {
        $articles=$ArticleRepo->findby([],['id'=>'asc']);
        return $this->render('blog/index.html.twig',compact('articles'));
    }
    #[Route('/blog/{id}', name: 'blog_article')]
    public function article(Article $article,Request $request,ManagerRegistry $manager): Response
    {
        $comment=new Comment();
        $comment->setAuthor($this->getUser());
        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        { 
            $em=$manager->getManager(); 
            $comment->setcreatedAt(new \DateTime())
                    ->setArticle($article);         
            $em->persist($comment);
            $em->Flush();
            return $this->redirectToRoute('blog_article', ['id'=>$article->getId()]);
        }
        return $this->render('blog/article.html.twig', [
            'article'=> $article,
            'form'=>$form->createView()
        ]);
    }
}
