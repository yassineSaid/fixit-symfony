<?php

namespace FrontBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use MainBundle\Entity\Horraire;
use MainBundle\Entity\Langue;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Repos;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\UserBundle;

class UserController extends Controller
{
    public function profilAction(Request $request)
    {
        $connect1=$this->getDoctrine()->getManager();
        $produits=$connect1->getRepository(Produit::class)->listMeilleursProduits($this->getUser()->getSolde());
        $connect=$this->getDoctrine()->getManager();
        $langues=$connect->getRepository(Langue::class)->findAll();

        return $this->render('@Front/User/dashboardprofilesetting.html.twig',array(
            "langues"=>$langues,
            "produits"=>$produits
        ));
    }
    public function rechercherAction(Request $request)
    {
        if ($request->get('languages') === null)
        {
            $languesR=[];
        }
        else $languesR=$request->get('languages');
        if ($request->get('zipcode') === null)
        {
            $zipcode="";
        }
        else $zipcode=$request->get('zipcode');
        if ($request->get('ville')===null)
        {
            $ville="";
        }
        else $ville=$request->get('ville');
        if ($request->isMethod('post')) $nom=$request->get('nom');
        else $nom="";
        $connect=$this->getDoctrine()->getManager();
        $users=$connect->getRepository(User::class)->listUsers($nom,$languesR,$zipcode,$ville);
        $langues=$connect->getRepository(Langue::class)->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9/*limit per page*/
        );
        return $this->render('@Front/User/rechercher.html.twig',array("users"=>$users,"ville"=>$ville,"zipcode"=>$zipcode,"nom"=>$nom,"pagination"=>$pagination));
    }
    public function ajouterPhotoAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect=$this->getDoctrine()->getManager();
            $user=$connect->getRepository(User::class)->find($this->getUser()->getId());
            $file=$request->files->get("image");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            if ($user->getImage()!=null)
            {
                {unlink($this->getParameter('user_directory').'/'.$user->getImage());}
            }
            $user->setImage($fileName);
            $file->move(
                $this->getParameter('user_directory'),
                $fileName
            );
            $connect->flush();
            return new Response('OK',200);
        }
        else return new Response('ERROR',500);
    }
    public function afficherUserAction($id)
    {
        
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->find($id);
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:ServiceUser");
        $services = $service->createQueryBuilder("q")
            ->where("q.idUser = :id")
            ->setParameter("id", $id)
            ->getQuery()
            ->getResult();
        $connect=$this->getDoctrine()->getManager();
        $langues=$connect->getRepository(User::class)->listLangueUser($id);
        $connect=$this->getDoctrine()->getManager();
        $connect1=$this->getDoctrine()->getManager();
        $horraires=$connect->getRepository(Horraire::class)->horrairesUser($id);
        $repos=$connect1->getRepository(Repos::class)->reposUser($id);
        return $this->render('@Front/User/afficherUser.html.twig',array(
            "user"=>$user,"services"=>$services,"langues"=>$langues,"horraires"=>$horraires,"repos"=>$repos
        ));
    }

}
