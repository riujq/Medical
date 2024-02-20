<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActuController extends AbstractController
{
    #[Route('/actu', name: 'app_actu')]
    public function index(ActuRepository $actuRepo): Response
    {
        $actus= $actuRepo->findby([],['date'=>'desc']);
        $a="tout";
        return $this->render('actu/index.html.twig',compact('actus','a'));
    }
    #[Route('actu/{id}', name: 'id_actu')]
    public function actu($id,ActuRepository $actuRepo): Response
    {
        $actus= $actuRepo->findByType($id);
        $a=$id;
        return $this->render('actu/index.html.twig',compact('actus','a'));
    }
}
