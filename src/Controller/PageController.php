<?php

namespace App\Controller;

use App\Form\CvType;
use App\Form\ContactType;
use App\Form\CategoryType;
use App\Service\FileService;
use App\Service\MailerService;
use App\Repository\ActuRepository;
use App\Repository\SlideRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/page/aboutUs', name: 'aboutUs')]
    public function index(): Response
    {
        return $this->render('page/aboutUs.html.twig');
    }
    #[Route('/page/quality', name: 'quality')]
    public function quality(): Response
    {
        return $this->render('page/qualite.html.twig');
    }
    #[Route('/page/career', name: 'career')]
    public function career(ActuRepository $careerRepo): Response
    {
        $careers= $careerRepo->findByType("Carrière");
        return $this->render('page/career.html.twig',compact('careers'));
    }
    #[Route('/page/metrocal', name: 'metrocal')]
    public function metrocal(SlideRepository $sliderepo): Response
    {
        $Slide=$sliderepo->findOneBy(['Titre' => "Calibration et Metrologie"]);
        return $this->render('page/metrocal.html.twig',compact('Slide'));
    }
    #[Route('/page/medicaux', name: 'medicaux')]
    public function medicaux(CategoryRepository $catrepo): Response
    {
        $cats=$catrepo->findAll();
        return $this->render('page/medicaux.html.twig',compact('cats'));
    }
    #[Route('/page/service', name: 'service')]
    public function service(CategoryRepository $catrepo): Response
    {
        $cat=$catrepo->findOneBy(['nom' => "SAV et Service Technique"]);
        return $this->render('page/service.html.twig',compact('cat'));
    }    
    #[Route('/page/contact', name: 'contact')]
    public function contact(Request $request,MailerService $mailer): Response
    {
        $Form= $this->createForm(ContactType::class);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {
            $Nom=$Form->get('Nom')->getData();
            $PhoneNumber=$Form->get('PhoneNumber')->getData();
            $Message=$Form->get('Message')->getData();
            $Email=$Form->get('Email')->getData();
            $context=compact('Nom','PhoneNumber','Message','Email');
            $mailer->sendMail('messagerie@mi-labotech.com',
                          'contact@medical-inter.com',
                          'Messages',
                          'mails/message.html.twig',
                          $context
            );
            $this->addFlash('info',"Message envoyer");
            return $this->redirectToRoute('home');
        }
        return $this->render('page/contact.html.twig',['form'=>$Form->createView()]);
    }
    #[Route('/page/post', name: 'post')]
    public function post(Request $request,MailerService $mailer,FileService $file): Response
    {
        $Form= $this->createForm(CvType::class);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {
            $Objet=$Form->get('Objet')->getData();
            $Nom=$Form->get('Nom')->getData();
            $PhoneNumber=$Form->get('PhoneNumber')->getData();
            $CV=$Form->get('CV')->getData();
            $Email=$Form->get('Email')->getData();
            $context=compact('Nom','PhoneNumber','CV');
            $mailer->sendMail('messagerie@mi-labotech.com',
                          'contact@medical-inter.com',
                          $Objet,
                          'mails/Cv.html.twig',
                          $context,
                          $CV
            );
            $this->addFlash('info',"CV envoyer");
            return $this->redirectToRoute('home');
        }
        return $this->render('page/contact.html.twig',['form'=>$Form->createView()]);
    }
}
