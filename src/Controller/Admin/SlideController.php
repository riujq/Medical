<?php

namespace App\Controller\Admin;

use App\Entity\Slide;
use App\Form\SlideType;
use App\Service\FileService;
use App\Repository\SlideRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/slide', name: 'admin_slide_')]
class SlideController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SlideRepository $SlideRepo):Response
    {
        $slides=$SlideRepo->findby([],['id'=>'asc']);
        return $this->render('admin/slide.html.twig',compact('slides'));
    }
    #[Route('/add', name: 'add')]
    #[Route('/edit/{id}', name: 'edit')]
    public function Form(?Slide $slide,Request $request, ManagerRegistry $manager,FileService $fileService): Response
    {  
        $slide = $slide ? $slide : new Slide();
        $Form=$this->CreateForm(SlideType::class,$slide);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {   
            $em=$manager->getManager();
            $image = $slide->getImage();
            $newImage= $Form->get('Image')->getData();
            if ($newImage) 
            {
                $fileService->delete_file($image);
                $slide->setImage($fileService->add_file($newImage));
            }
            $em->persist($slide);
            $em->Flush();
            return $this->redirectToRoute('admin_slide_index');
        }
        if($request->get('ajax')){
            return new JsonResponse([
                'content'=> $this->renderView('admin/form.html.twig',['form' => $Form->createView()]),
                'foot'=>'',
                'title'=> $slide->getTitre() ? "Modifier Slide" : "Nouveau Slide"
            ]);
        }
        return $this->redirectToRoute('admin_slide_index');
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Slide $slide,ManagerRegistry $manager,FileService $fileService,Request $request): Response
    {   
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer cette slide",
                'title'=> 'Suppression',
                'foot'=>$this->renderView('admin/confirm.html.twig',['Action'=>'Supprimer','color'=>'danger'])
            ]);
        }
        $images=$slide->getImage();
        $fileService->delete_file($images);
        $em=$manager->getManager();
        $em->remove($slide);
        $em->Flush();        
        $this->addFlash('info',"Le slide a été supprimé avec succès");
        return $this->redirectToRoute('admin_slide_index');
    } 
}