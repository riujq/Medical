<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use function PHPUnit\Framework\throwException;

class FileService extends AbstractController
{
    public function __construct(private SluggerInterface $slugger){}

    public function add_file(UploadedFile $file):string
    {      
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try 
        {
            $file->move($this->getDirectory($file),$newFilename);
        } 
        catch (FileException $e) 
        {
            $this->addFlash('danger',$e);
        }
        return  $newFilename;
    }
    public function delete_file(String $file)
    {
        if($file)
        {
            if (file_exists($this->getParameter("image_directory").'/'.$file))
            {
                unlink($this->getParameter("image_directory").'/'.$file);
            }
            elseif (file_exists($this->getParameter("video_directory").'/'.$file)) 
            {
                unlink($this->getParameter("video_directory").'/'.$file);
            }
            elseif (file_exists($this->getParameter("files_directory").'/'.$file)) 
            {
                unlink($this->getParameter("files_directory").'/'.$file);
            }
        }
    }
    public function getDirectory(UploadedFile $file):string
    {
        $type=$file->getMimeType();
        $array= explode('/',$type);
        if($array[0]=='image' or $array[0]=='video')
        {
            return $this->getParameter($array[0].'_directory');
        }
        return $this->getParameter("files_directory");
    }
}