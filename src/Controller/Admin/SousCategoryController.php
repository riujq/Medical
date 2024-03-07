<?php

namespace App\Controller\Admin;

use App\Entity\SousCategory;
use App\Form\SousCategoryType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\SousCategoryRepository;
use App\Service\FileService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/souscategory', name: 'admin_souscategory_')]
class SousCategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SousCategoryRepository $CategoryRepo):Response
    {
        $categories=$CategoryRepo->findby([],['id'=>'asc']);
        return $this->render('admin/souscategory.html.twig',compact('categories'));
    }
    #[Route('/add', name: 'add')]
    #[Route('/edit/{id}', name: 'edit')]
    public function Form(?SousCategory $category,Request $request, ManagerRegistry $manager,FileService $fileService): Response
    {  
        $category = $category ? $category : new sousCategory();
        $Form=$this->CreateForm(SousCategoryType::class,$category);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {   
            $em=$manager->getManager();
            $image = $category->getImage();
            $newImage= $Form->get('Image')->getData();
            if ($newImage) 
            {
                $fileService->delete_file($image);
                $category->setImage($fileService->add_file($newImage));
            }
            $em->persist($category);
            $em->Flush();
            return $this->redirectToRoute('admin_souscategory_index');
        }
        if($request->get('ajax')){
            return new JsonResponse([
                'content'=> $this->renderView('admin/form.html.twig',['form' => $Form->createView()]),
                'foot'=>'',
                'title'=> $category->getnom() ? "Modifier Sous-Catégorie" : "Nouveau Sous-Catégorie"
            ]);
        }
        return $this->redirectToRoute('admin_souscategory_index');
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(SousCategory $category,ManagerRegistry $manager,Request $request,FileService $fileService): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer cette Sous-Catégorie",
                'title'=> 'Suppression',
                'foot'=>$this->renderView('admin/confirm.html.twig',['Action'=>'Supprimer','color'=>'danger'])
            ]);
        }
        $images=$category->getImage();
        $fileService->delete_file($images);       
        $em=$manager->getManager();
        $em->remove($category);
        $em->Flush();        
        $this->addFlash('info',"La catégorie a été supprimé avec succès");
        return $this->redirectToRoute('admin_souscategory_index');
    } 
}