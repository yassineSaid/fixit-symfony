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

        return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil,"tri"=>"","triDSC"=>""));
    }
    public function afficherTriFrontAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        $em2=$this->getDoctrine()->getManager();
        $categorie2=$em2->getRepository(CategorieOutils::class)->listeCategorieRestreinte();
        $em1=$this->getDoctrine()->getManager();
        $outil=$em1->getRepository(Outils::class)->findAll();
        if (isset($_GET['tri'])or isset($_GET['triDSC']))
        {

            if(($request->get("tri")=="nom?triDSC=asc"))
            {
                $outil1=$em1->getRepository(Outils::class)->triNomASC();
                return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil1,"tri"=>"nom","triDSC"=>"asc"));
            }
            elseif (($request->get("tri")=="prix?triDSC=asc"))
            {
                $outil2=$em1->getRepository(Outils::class)->triPrixASC();
                return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil2,"tri"=>"prix","triDSC"=>"asc"));
            }
            elseif (($request->get("tri")=="nom?triDSC=dsc"))
            {
                $outil1=$em1->getRepository(Outils::class)->triNomDSC();
                return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil1,"tri"=>"nom","triDSC"=>"dsc"));
            }
            elseif (($request->get("tri")=="prix?triDSC=dsc"))
            {
                $outil1=$em1->getRepository(Outils::class)->triPrixDSC();
                return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil1,"tri"=>"prix","triDSC"=>"dsc"));
            }

        }

            return $this->render("@Front/Outil/liste.html.twig",array("categorie2"=>$categorie2,"categorie"=>$categorie,"outil"=>$outil,"tri"=>"","triDSC"=>""));


    }
    public function louerAction(Request $request)
    {
        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        $user=$this->getUser();

        return $this->render("@Front/Outil/louer.html.twig",array("outil"=>$outil,"user"=>$user));
    }

}
