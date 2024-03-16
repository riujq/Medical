<?php

namespace App\Service;

use Symfony\Component\Mime\Part\File;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerService extends AbstractController
{
    public function __construct(private MailerInterface $mailer,private SluggerInterface $slugger){}

    public function sendMail($from,$to,$titre,$html,$context,$cv=null)
    {
        $email = (new TemplatedEmail())
        ->from($from)
        ->to($to)
        ->subject($titre)
        ->htmlTemplate($html)
        ->context($context); 
        if($cv){
            $newFilename = $this->slugger->slug(pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME)).'-'.uniqid().'.'.$cv->guessExtension();
            $cv->move($this->getParameter("files_directory"),$newFilename);
            $email->addPart(new DataPart(new File($this->getParameter("files_directory").'/'.$newFilename), 'CV'));
            $this->mailer->send($email);
            unlink($this->getParameter("files_directory").'/'.$newFilename);
        }else{
            $this->mailer->send($email);
        }
    }
}