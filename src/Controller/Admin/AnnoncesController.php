<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/annonces', name: 'admin_annonces_')]
class AnnoncesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AnnoncesRepository $AnnoncesRepo): Response
    {
        $annonces=$AnnoncesRepo->findby([],['id'=>'asc']);
        return $this->render('admin/annonces.html.twig',compact('annonces'));
    }
    #[Route('/add', name: 'add')]
    #[Route('/edit/{id}', name: 'edit')]
    public function Form(Annonces $annonces=null,Request $request, ManagerRegistry $manager): Response
    {  
        $title= $annonces ? "Modifier l'annonce" : "Ajouter une annonce";
        $annonces = $annonces ? $annonces : new Annonces();
        $Form=$this->CreateForm(AnnoncesType::class,$annonces);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {          
            $em=$manager->getManager();
            $em->persist($annonces);
            $em->Flush();
            return $this->redirectToRoute('admin_annonces_index');
        }
        return $this->render('admin/form.html.twig',['form' => $Form->createView(),"title" => $title]);
    }  
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Annonces $annonces,ManagerRegistry $manager,Request $request): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer cette annonce",
                'title'=> 'Suppression'
            ]);
        }          
        $em=$manager->getManager();
        $em->remove($annonces);
        $em->Flush();        
        $this->addFlash('info',"L'annonce a été supprimé avec succès");
        return $this->redirectToRoute('admin_annonces_index');
    } 
    #[Route('/active/{id}', name: 'active')]
    public function active(Annonces $annonces,ManagerRegistry $manager,Request $request): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir activer cette annonce",
                'title'=> 'Activation',
                'foot'=>$this->renderView('admin/confirm.html.twig',['Action'=>'Activer','color'=>'primary'])
            ]);
        }          
        $em=$manager->getManager();
        $a=$manager->getRepository(Annonces::class)->findAll();
        foreach ($a as $annonce ){
            $annonce->setActive(false);
        }
        $annonces->setActive(true);
        $em->persist($annonces);
        $em->Flush();        
        $this->addFlash('info',"L'annonce a été activé avec succès");
        return $this->redirectToRoute('admin_annonces_index');
    } 
}