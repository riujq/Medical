<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\LigneCmd;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{

    public function __construct(private RequestStack $requestStack, private ProduitRepository $produitRepository){}

    public function add($id)
    {
       
        $panier=$this->requestStack->getSession()->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;}
        else{
            $panier[$id]=1;
        }
        
        $this->requestStack->getSession()->set('panier',$panier);
    }
    public function qty($id,$q)
    {     
        $panier=$this->requestStack->getSession()->get('panier',[]);
        if(!empty($panier[$id]))
        {
            $panier[$id]+=$q;
        }
        else
        {
            $panier[$id]=$q;
        }   
        $this->requestStack->getSession()->set('panier',$panier);
    }
    public function decrease($id)
    {
        $panier=$this->requestStack->getSession()->get('panier',[]);
        if(!empty($panier[$id]))
        {
            if($panier[$id]>1)
            {
                $panier[$id]--;
            }
           else{unset($panier[$id]);}
        }        
        $this->requestStack->getSession()->set('panier',$panier);
    }
    public function delete($id)
    {
        $panier=$this->requestStack->getSession()->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }     
        $this->requestStack->getSession()->set('panier',$panier);
    }
    public function vider()
    {
        $this->requestStack->getSession()->remove('panier');
    }
    public function getFullCart():array
    {
        $panier=$this->requestStack->getSession()->get('panier',[]);
        $panierTab=[];
        foreach($panier as $id=>$quantity){
            $panierTab[]=[
                'product'=>$this->produitRepository->find($id),
                'quantity'=>$quantity
            ];
        }
        return $panierTab;
    }
    public function getTotal():float
    {
        $Total=0;
        $panierTab=$this->getFullCart();
        foreach($panierTab as $items)
        {
            $TotalItems=$items['product']->getPrix() * $items['quantity'];
            $Total+=$TotalItems;
        }
        return $Total;
    }
    public function addToPanier($produit,$quantity,$total,$Cmd):object
    {
        $cart=new LigneCmd();
        $cart->setProduits($produit);
        $cart->setQuantity($quantity);
        $cart->setTotal($total);
        $cart->setCommande($Cmd);
        return $cart;
    }
    public function addToCmd($T,$U,$D):object
    {
        $Cmd=new Commande();
        $Cmd->setUser($U);
        $Cmd->setTotal($T);
        $Cmd->setCreatedAt($D);
        return $Cmd;
    }
}