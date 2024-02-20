<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Form\ReqPassType;
use App\Form\ResetPassType;
use App\Service\JWTService;
use App\Form\RegistrationType;
use App\Service\MailerService;
use App\Controller\BaseController;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends BaseController
{
    #[Route('/login', name: 'security_login')]
    public function Login(AuthenticationUtils $authenticationUtils): Response
    {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/Login.html.twig', [
             'controller_name' => 'LoginController',
             'last_username' => $lastUsername,
             'error'         => $error,
        ]);
    }
    #[Route('/registration', name: 'security_registration')]
    public function Registration(UserPasswordHasherInterface $passwordHasher,Request $request,ManagerRegistry $manager): Response
    {
         $user = new User();
         $Form=$this->createForm(RegistrationType::class,$user);
         $Form->handleRequest($request);
         if($Form->isSubmitted() && $Form->isValid())
         {
            $plaintextPassword=$user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
            $user->setPassword($hashedPassword);
            $em=$manager->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success',"Inscription terminer!!! Bienvenue");
            return $this->redirectToRoute('home');
         }
        return $this->render('security/Registration.html.twig', [
             'form' => $Form->createView() ]);
    }
    #[Route('/logout', name: 'security_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
    #[Route('/forgetPass', name: 'forget_pass')]
    public function forgetPass(UserRepository $userRepo,ManagerRegistry $manager,Request $request,TokenGeneratorInterface $TokenGenerator,MailerService $mailer): Response
    {
        $Form=$this->createForm(ReqPassType::class);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid())
        {
            $user=$userRepo->FindOneByEmail($Form->get('email')->getData());
            if($user){
                $Token=$TokenGenerator->generateToken();
                $user->setResetToken($Token);
                $em=$manager->getManager();
                $em->persist($user);
                $em->flush();
                $url=$this->generateUrl('reset_pass',['Token'=>$Token],UrlGeneratorInterface::ABSOLUTE_URL);
                $context=compact('url','user');
                $mailer->sendMail('contact@medical-inter.com',
                              $user->getEmail(),
                              'Réinitialisation de mot de passe!',
                              'mails/resetPass.html.twig',
                              $context
                );
                $this->addFlash('info',"requete envoyer avec succès,verifier vos emails");
                return $this->redirectToRoute('security_login');
            }
            $this->addFlash('notice',"Aucun email correspondant trouver");
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/ResetPass.html.twig', [
             'form' => $Form->createView() ]);
    }
    #[Route('/resetPass/{Token}', name: 'reset_pass')]
    public function resetPass(
        string $Token,UserRepository $userRepo,EntityManagerInterface $em,Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {
        $user=$userRepo->FindOneByResetToken($Token);
        if($user){ 
            $Form=$this->createForm(ResetPassType::class,$user);
            $Form->handleRequest($request);
            if($Form->isSubmitted() && $Form->isValid())
            {
                $user->setResetToken('');
                $hashedPassword=$passwordHasher->hashPassword($user, $Form->get('password')->getData());
                $user->setPassword($hashedPassword);
                $em->persist($user);
                $em->flush();
                $this->addFlash('success',"Mot de passe modifier avec succès");
                return $this->redirectToRoute('security_login');
            }    
            return $this->render('security/ResetPass.html.twig', [
                'form' => $Form->createView() ]);
        }
        $this->addFlash('notice',"Jeton invalide");
        return $this->redirectToRoute('security_login');
    }
    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser(string $token,JWTService $jwt,UserRepository $userRepo,EntityManagerInterface $em): Response
    { 
        //on verifier si le token est valide , n'a pas expiré et n'a pas été mmodifié
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token,$this->getParameter('app.jwtsecret')) ){
            //on récupère le payload
            $payload=$jwt->getPayload($token);
            //on récupère le user du token par payload
            $user= $userRepo->find($payload['user_id']);
            //on verifier que l'utilisateur existe et n'a pas verifier so compte
             if( $user && ! $user->getIsVerified() ){
                $user->setIsVerified(true);
                $em->persist($user);
                $em->flush();
                $this->addFlash('info',"Votre compte est activé");
                return $this->redirectToRoute('home');
             }
        }
        //un probleme dans le token
        $this->addFlash('danger',"Le token est invalide ou a expiré");
        return $this->redirectToRoute('security_login');
    }
    #[Route('/reverif', name: 'resend_verify')]
    public function resendVerify(JWTService $jwt,UserRepository $userRepo,EntityManagerInterface $em,MailerService $mailer): Response
    {  
        $user=$this->getUser();
        if(!$user){
            $this->addFlash('danger',"Vous devez vous connectez");
            return $this->redirectToRoute('home');
        }
        if($user->getIsVerified()){
            $this->addFlash('warning',"Utilisateur déjà activé");
            return $this->redirectToRoute('home');
        }
        $header=[
            'typ'=>'JWT',
            'alg'=>'HS256'
        ];
        $payload=[
            'user_id'=>$user->getId(),
        ];
        $token=$jwt->generate($header,$payload,$this->getParameter('app.jwtsecret'));
        $context=compact('user','token');
        $mailer->sendMail('contact@medical-inter.com',
        $user->getEmail(),
        'Activation du compte',
        'mails/verifMail.html.twig',
        $context
        );
        $this->addFlash('info',"email de vérification envoyer, vérifier vos emails");
        return $this->redirectToRoute('home');
    }
}