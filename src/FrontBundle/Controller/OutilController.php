<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieOutils;
use MainBundle\Entity\Outils;

class OutilController extends Controller
{
    public function afficherFrontAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        $em2=$this->getDoctrine()->getManager();
        $categorie2=$em2->getRepository(CategorieOutils::class)->listeCategorieRestreinte();
        $em1=$this->getDoctrine()->getManager();
        $outil=$em1->getRepository(Outils::class)->findAll();

        return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil,"tri"=>""));
    }
    public function afficherTriFrontAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        $em2=$this->getDoctrine()->getManager();
        $categorie2=$em2->getRepository(CategorieOutils::class)->listeCategorieRestreinte();
        $em1=$this->getDoctrine()->getManager();
        $outil=$em1->getRepository(Outils::class)->findAll();
        if (isset($_GET['tri']))
        {
            if($request->get("tri")=="nom")
            {
                $outil1=$em1->getRepository(Outils::class)->triNomASC();
                return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil1,"tri"=>"nom"));
            }
            elseif ($request->get("tri")=="prix")
            {
                $outil2=$em1->getRepository(Outils::class)->triPrixASC();
                return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil2,"tri"=>"prix"));
            }

        }
        else
        {
            return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil,"tri"=>""));
        }

    }
}
