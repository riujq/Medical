<?php

namespace App\Twig;

use App\Entity\Actu;
use App\Entity\Annonces;
use App\Controller\BaseController;
use Doctrine\ORM\EntityManagerInterface;

class Extension extends BaseController 
{
    public function __construct(private EntityManagerInterface $em){}

    public function promo()
    {      
        return $this->em->getRepository(Actu::class)->findOneByType('Promotion');
    }
    public function date()
    {      
        return new \DateTime();
    }
    public function annonces()
    {      
        return $this->em->getRepository(Annonces::class)->findByannonce();
    }
}