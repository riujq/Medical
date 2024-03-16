<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditRoleType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_users_index')]
    public function index(UserRepository $UserRepo):Response
    {
        $users=$UserRepo->findby([],['id'=>'asc']);
        return $this->render('admin/user.html.twig',compact('users'));
    }
    #[Route('/superadmin/users/delete/{id}',name:'superadmin_users_delete')]
    public function delete(User $user,ManagerRegistry $manager,Request $request):Response
    {
        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content'=> "Êtes-vous sûr(e) de vouloir supprimer cette utilisateur",
                'title'=> 'Suppression'
            ]);
        }
        $em=$manager->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('info',"L'utilisateur a été supprimé avec succès");
        return $this->redirectToRoute('admin_users_index'); 
    }
    #[Route('/superadmin/users/edit/{id}',name:'superadmin_users_edit')]
    public function edit(User $user,ManagerRegistry $manager,Request $request):Response
    {
        $em=$manager->getManager();
        $form=$this->createForm(EditRoleType::class,$user);
        $form->handleRequest($request);       
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $user->setRoles($form->get('roles')->getData());
            $em->persist($user);
            $em->flush();
            $this->addFlash('info',"Modification terminer");
            return $this->redirectToRoute('admin_users_index');
        }
        return $this->render('admin/form.html.twig',['form' => $form->createView(),"title" => "Modifier le rôle de l'utilisateur"]);
    }
}