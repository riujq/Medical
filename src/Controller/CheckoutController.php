<?php

namespace App\Controller;

use App\Form\CheckoutType;
use App\Service\CartService;
use App\Service\MailerService;
use App\Service\TexterService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
/*     #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request,ManagerRegistry $manager,CartService $cartservice,MailerService $mailer,TexterService $texter): Response
    {
        $User=$this->getUser();
        $panier=$cartservice->getFullCart();
        $T=$cartservice->getTotal();
        $Form=$this->CreateForm(CheckoutType::class,$User);
        if(!$panier)
        {
            return $this->redirectToRoute("app_produit");
        }
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {       
            $date=new \DateTime();  
            $Cmd=$cartservice->addToCmd($T,$User,$date);
            $em=$manager->getManager();          
            $em->persist($User);
            $em->persist($Cmd);
            foreach($panier as $items)
            {
                $TotalItems=$items['product']->getPrix() * $items['quantity'];
                $produit=$items['product'];
                $quantity=$items['quantity'];
                $cart=$cartservice->addToPanier($produit,$quantity,$TotalItems,$Cmd);
                $em->persist($cart);
            }         
            $em->Flush();
            $context=['user' => $User,'items' => $panier,'T' => $T,];
            $mailer->sendMail($User->getUserIdentifier(),'contact@medical-inter.com','Bon de commande numero:'.$Cmd->getId(),'mails/commande.html.twig',$context);
            $texter->sendSms($F->get('PhoneNumber')->getData(),'veuillez payer la somme total par MVOLA au numero 0349189854');
            $cartservice->vider();
            $this->addFlash('success',"Votre commande a été prise en compte");
            return $this->redirectToRoute("app_produit");
        }
        return $this->render('checkout/index.html.twig', [
            'form' => $Form->createView(),
            'items' => $panier,
            'T' => $T
        ]);
    } */
}
