<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Service\FileService;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/admin/produit', name: 'admin_product_')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProduitRepository $ProduitRepo,EntityManagerInterface $em):Response
    {
        $produits=$ProduitRepo->findby([],['nom'=>'desc']);
        return $this->render('admin/produit.html.twig',compact('produits'));
    }
    #[Route('/add', name: 'add')]
    #[Route('/edit/{id}', name: 'edit')]
    public function Form(Produit $produit=null,Request $request, ManagerRegistry $manager,FileService $fileService): Response
    {  
        $produit = $produit ? $produit : new produit();
        $Form=$this->CreateForm(ProduitType::class,$produit);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {          
            $em=$manager->getManager();
            $image = $produit->getImage();
            $newImage= $Form->get('Image')->getData();
            if ($newImage) 
            {
                $fileService->delete_file($image);
                $produit->setImage($fileService->add_file($newImage));
            }
            $em->persist($produit);
            $em->Flush();
            return $this->redirectToRoute('admin_product_index');
        }
        if($request->get('ajax')){
            return new JsonResponse([
                'content'=> $this->renderView('admin/form.html.twig',['form' => $Form->createView()]),
                'foot'=>'',
                'title'=> $produit->getNom() ? "Modifier Produit" : "Nouveau Produit"
            ]);
        }
        return $this->redirectToRoute('admin_product_index');
    }  
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Produit $produit,ManagerRegistry $manager,FileService $fileService,Request $request): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer le produit",
                'title'=> 'Suppression',
                'foot'=>$this->renderView('admin/confirm.html.twig',['Action'=>'Supprimer','color'=>'danger'])
            ]);
        }
        $images=$produit->getImage();
        $fileService->delete_file($images);
        $em=$manager->getManager();
        $em->remove($produit);
        $em->Flush();        
        $this->addFlash('info',"Le produit a été supprimé avec succès");
        return $this->redirectToRoute('admin_product_index');
    } 
}