<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $CategoryRepo):Response
    {
        $categories=$CategoryRepo->findby([],['id'=>'asc']);
        return $this->render('admin/category.html.twig',compact('categories'));
    }
    #[Route('/add', name: 'add')]
    #[Route('/edit/{id}', name: 'edit')]
    public function Form(?Category $category,Request $request, ManagerRegistry $manager): Response
    {  
        $title= $category ? "Modifier Catégorie" : "Nouveau Catégorie";
        $category = $category ? $category : new Category();
        $Form=$this->CreateForm(CategoryType::class,$category);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {   
            $em=$manager->getManager();
            $em->persist($category);
            $em->Flush();
            return $this->redirectToRoute('admin_category_index');
        }
        return $this->render('admin/form.html.twig',['form' => $Form->createView(),"title" => $title]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Category $category,ManagerRegistry $manager,Request $request): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer cette Catégorie",
                'title'=> 'Suppression'
            ]);
        }
        $em=$manager->getManager();
        $em->remove($category);
        $em->Flush();        
        $this->addFlash('info',"La catégorie a été supprimé avec succès");
        return $this->redirectToRoute('admin_category_index');
    } 
}