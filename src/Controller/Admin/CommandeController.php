<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\LigneCmdRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/commande', name: 'admin_commande_')]
class CommandeController extends AbstractController
{
/*     #[Route('/', name: 'index')]
    public function index(CommandeRepository $commandeRepo):Response
    {
        $commandes=$commandeRepo->findby([],['CreatedAt'=>'asc']);
        return $this->render('admin/commande.html.twig',compact('commandes'));
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Commande $commande,ManagerRegistry $manager,LigneCmdRepository $ligneCmdRepo): Response
    {   
        $em=$manager->getManager();       
        if($commande)
        {   
            $cmds=$ligneCmdRepo->findBy(['commande'=>$commande]);
            foreach($cmds as $cmd){ $em->remove($cmd);}
            $em->remove($commande);
            $em->Flush();        
            $this->addFlash('info',"La commande a été supprimé avec succès");
        }
        return $this->redirectToRoute('admin_commande_index');
    } 
    #[Route('/details/{id}', name: 'details')]
    public function details(Commande $commande): Response
    {   
        $commandes=$commande->getLigneCmds();
        return $this->render('admin/details.html.twig',compact('commandes'));
    } */
}