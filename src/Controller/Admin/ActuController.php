<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use App\Form\ActuType;
use App\Service\FileService;
use App\Repository\ActuRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/actu', name: 'admin_actu_')]
class ActuController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ActuRepository $ActuRepo): Response
    {
        $actus=$ActuRepo->findby([],['id'=>'asc']);
        return $this->render('admin/actu.html.twig',compact('actus'));
    }
    #[Route('/add', name: 'add')]
    #[Route('/edit/{id}', name: 'edit')]
    public function Form(Actu $actu=null,Request $request, ManagerRegistry $manager,FileService $fileService): Response
    {  
        $actu = $actu ? $actu : new actu();
        $Form=$this->CreateForm(ActuType::class,$actu);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {          
            $em=$manager->getManager();
            $image = $actu->getImage();
            $newImage= $Form->get('image')->getData();
            if ($newImage) 
            {
                $fileService->delete_file($image);
                $actu->setImage($fileService->add_file($newImage));
            }
            $em->persist($actu);
            $em->Flush();
            return $this->redirectToRoute('admin_actu_index');
        }
        if($request->get('ajax')){
            return new JsonResponse([
                'content'=> $this->renderView('admin/form.html.twig',['form' => $Form->createView()]),
                'foot'=>'',
                'title'=> $actu->getNom() ? "Modifier l'actualité" : "Ajouter une actualité"
            ]);
        }
        return $this->redirectToRoute('admin_actu_index');
    }  
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Actu $actu,ManagerRegistry $manager,FileService $fileService,Request $request): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer cette actualité",
                'title'=> 'Suppression',
                'foot'=>$this->renderView('admin/confirm.html.twig',['Action'=>'Supprimer','color'=>'danger'])
            ]);
        }
        $images=$actu->getImage();           
        $em=$manager->getManager();
        $fileService->delete_file($images);
        $em->remove($actu);
        $em->Flush();        
        $this->addFlash('info',"L'actu a été supprimé avec succès");
        return $this->redirectToRoute('admin_actu_index');
    } 
}
