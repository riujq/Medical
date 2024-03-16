<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Form\ProduitType;
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
    public function Form(Produit $produit=null,Request $request, ManagerRegistry $manager): Response
    {         
        $title= $produit ? "Modifier Produit" : "Nouveau Produit";
        $produit = $produit ? $produit : new produit();
        $Form=$this->CreateForm(ProduitType::class,$produit);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {          
            $em=$manager->getManager();
            $em->persist($produit);
            $em->Flush();
            return $this->redirectToRoute('admin_product_index');
        }
        return $this->render('admin/form.html.twig',['form' => $Form->createView(),"title" => $title]);
    }  
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Produit $produit,ManagerRegistry $manager,Request $request): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer le produit",
                'title'=> 'Suppression'
            ]);
        }
        $em=$manager->getManager();
        $em->remove($produit);
        $em->Flush();        
        $this->addFlash('info',"Le produit a été supprimé avec succès");
        return $this->redirectToRoute('admin_product_index');
    } 
}