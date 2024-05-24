<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{

    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $produitRepo): Response
    {
        $produit=$produitRepo->findby([],['nom'=>'asc']);
        $c=false;
        return $this->render('produit/index.html.twig',compact('produit','c'));
    }
    #[Route('/produit/{id<\d+>}', name: 'single_produit')]
    public function singleprod($id,ManagerRegistry $manager): Response
    {
        $em=$manager->getRepository(persistentObject: Produit::class);
        $produit= $em->find($id);
        return $this->render('produit/singleproduit.html.twig',compact('produit'));
    }
    #[Route('/produit/category/{id}', name: 'cat_produit')]
    public function prodcat($id,ProduitRepository $produitRepo): Response
    {
        $produit= $produitRepo->findByCat($id);
        $c="cat";
        return $this->render('produit/index.html.twig',compact('produit','c'));
    }
    #[Route('/produit/{cat}/{scat}', name: 'find_produit')]
    public function prodscat($cat,$scat,ProduitRepository $produitRepo): Response
    {
        $produit= $produitRepo->findByScat($cat,$scat);
        $c="scat";
        return $this->render('produit/index.html.twig',compact('produit','c'));
    }
    #[Route('/search/produit', name: 'search_produit')]
    public function search(ProduitRepository $produitRepo, Request $request): Response
    {
            $mot=$request->request->get('mots');
            $produit = $produitRepo->search($mot);
            $c=false;      
            if($produit==null){
                $this->addFlash('warning',"aucun résultat");
                return $this->redirectToRoute('app_produit');
            }
            return $this->render('produit/index.html.twig',compact('produit','c'));
    }
}
