<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function index(): Response   //action:méthode qui s'exécute si on l'invoque via la route
    {
        $formation = "BootCamp Symfony REAN DEVOPS";
        $duree = "60 heures";
        $mode ="Hybride";
        $formateur="Mohamed Amine Mezghich";
        $stagiaires = ["Wael","Saber","Hosni","Affif","Amira","Sonny"];
        $camps=["Symfony","REAN","DEVOPS"];
      
       // return new Response("<h1 align=center>Hello To Symfony</h1>" ." ".$formation);
       return $this->render('front/welcome.html.twig',
       [
        'formation'=>$formation,
        'duree'=>$duree,
        'mode'=>$mode,
        'formateur'=>$formateur,
        'stagiaires'=>$stagiaires,
        'camps' => $camps
       ]
    );
    }
}
