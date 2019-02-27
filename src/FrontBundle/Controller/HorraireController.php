<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\Horraire;
use MainBundle\Entity\Repos;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HorraireController extends Controller
{
    public function modifierAction()
    {
        /*$connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $service=$connexion->getRepository("MainBundle:Service")->findAll();*/
        // $group=$connexion->getRepository("MainBundle:Service")->groupByCat();
        $connexion=$this->getDoctrine();
        $horraires=$connexion->getRepository(Horraire::class)->horrairesUser($this->getUser()->getId());
        return $this->render('@Front/Horraire/horrairesetting.html.twig',array("horraires"=>$horraires));
    }
    public function listAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect=$this->getDoctrine()->getManager();
            $connect1=$this->getDoctrine()->getManager();
            $horraires=$connect->getRepository(Horraire::class)->horrairesUser($this->getUser()->getId());
            $repos=$connect1->getRepository(Repos::class)->reposUser($this->getUser()->getId());
            return new JsonResponse(array("horraires"=>$horraires,"repos"=>$repos));
            //var_dump($langues);
        }
        return false;
    }
    public function supprimerAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect=$this->getDoctrine()->getManager();
            $horraire=$connect->getRepository(Horraire::class)->find($request->get("idHorraire"));
            $connect->remove($horraire);
            $connect->flush();
            return new Response("OK",200);
        }
        return new Response("FAILED",500);
    }
    public function supprimerReposAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect=$this->getDoctrine()->getManager();
            $connect->getRepository(Repos::class)->supprimerRepos(
                $request->get("idUser"),$request->get('idJour')
            );
            return new Response("OK",200);
        }
        return new Response("FAILED",500);
    }
    public function supprimerJourAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect=$this->getDoctrine()->getManager();
            $connect1=$this->getDoctrine()->getManager();
            $repos=new Repos();
            $repos->setUser($this->getUser());
            $repos->setId($request->get('idJour'));
            $connect1->persist($repos);
            $connect1->flush();
            $connect->getRepository(Horraire::class)->supprimerJour(
                $request->get('idUser'),$request->get('idJour')
            );
            //$connect->getRepository(Horraire::class)->supprimerJour(12,0);
            return new Response("OK",200);
        }
        return new Response("FAILED",500);
    }
    public function ajouterAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $heureDebut=\DateTime::createFromFormat('H:i',$request->get('heureDebut'));
            $heureFin=\DateTime::createFromFormat('H:i',$request->get('heureFin'));
            $connect1=$this->getDoctrine()->getManager();
            $connect2=$this->getDoctrine()->getManager();
            $user=$connect2->getRepository(User::class)->find($request->get('idUser'));
            $horraire=new Horraire();
            $horraire->setUser($user);
            $horraire->setHeureDebut($heureDebut);
            $horraire->setHeureFin($heureFin);
            $horraire->setJour($request->get('jour'));
            $connect1->persist($horraire);
            $connect1->flush();
            return new Response("OK",200);
        }
        return false;
    }
}
