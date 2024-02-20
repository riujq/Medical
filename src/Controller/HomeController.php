<?php

namespace App\Controller;

use App\Entity\Slide;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $manager): Response
    {
        $em=$manager->getRepository(persistentObject: Slide::class);
        $slides= $em->findAll();
        return $this->render('home/index.html.twig',compact('slides'));
    }
}
