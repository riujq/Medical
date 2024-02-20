<?php

namespace App\Service;

use App\Service\FileService;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerService extends AbstractController
{
    public function __construct(private MailerInterface $mailer,private FileService $FileService){}

    public function sendMail($from,$to,$titre,$html,$context,$cv=null)
    {
        $email = (new TemplatedEmail())
        ->from($from)
        ->to($to)
        ->subject($titre)
        ->htmlTemplate($html)
        ->context($context); 
        if($cv){
            $file=$this->FileService->add_file($cv);
            $email->addPart(new DataPart(new File($this->getParameter("files_directory").'/'.$file), 'CV'));
            $this->mailer->send($email);
            $this->FileService->delete_file($file);
        }else{
            $this->mailer->send($email);
        }
    }
}