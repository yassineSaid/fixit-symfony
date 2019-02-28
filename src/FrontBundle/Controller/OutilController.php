<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\Notification;
use MainBundle\Entity\UserOutil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieOutils;
use MainBundle\Entity\Outils;
use Symfony\Component\Validator\Constraints\DateTime;

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
    public function detailAction(Request $request)
    {
        $id=$_GET['id'];
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $em1=$this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        $userOutil=$em2->getRepository(UserOutil::class)->premierOutilDQL($id);
        $userOutil2=$em1->getRepository(UserOutil::class)->location($outil,$user);


        if($outil->getQuantite()>0)
        {
            if($userOutil2==null)
            {
                return $this->render("@Front/Outil/deatils.html.twig",array("outil"=>$outil,"user"=>$user));
            }
            else
            {
                return $this->render("@Front/Outil/dejaLoue.html.twig",array("uo"=>$userOutil2,"outil"=>$outil));
            }
        }
        else
        {
            if($userOutil==null)
            {
                return $this->render("@Front/Outil/epuiser.html.twig",array("outil"=>$outil));
            }
            elseif ($userOutil2!=null)
            {
                return $this->render("@Front/Outil/dejaLoue.html.twig",array("uo"=>$userOutil2,"outil"=>$outil));
            }
            else
            {
                return $this->render("@Front/Outil/indisponible.html.twig",array("outil"=>$outil,"userOutil"=>$userOutil));
            }
        }

    }
    public function louerAction(Request $request)
    {
        $idOutil=$_GET['id'];
        $user=$this->getUser();
        if($user->getSolde()>=($request->get("prixTotal")))
        {

            $connect1=$this->getDoctrine()->getManager();
            $connect2=$this->getDoctrine()->getManager();
            $outil=$connect2->getRepository(Outils::class)->find($idOutil);
            $outil->setQuantite($outil->getQuantite()-1);
            $user->setSolde($user->getSolde()-($request->get("prixTotal")));
            $userOutil=new UserOutil();
            $userOutil->setIdUser($user);
            $userOutil->setIdOutil($outil);
            $userOutil->setDateLocation(new \DateTime($request->get("dateLocation")));
            $userOutil->setDateRetour(new \DateTime($request->get("dateRetour")));
            $userOutil->setTotal($request->get("prixTotal"));
            $connect1->persist($userOutil);
            $connect1->flush();
            return $this->redirectToRoute("front_afficherFrontOutil");

        }
        else
        {
            return $this->redirectToRoute("profile_setting");
        }

    }
    public function ListeCategorieAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->findAll();
        return $this->render('@Front/Outil/listCategorieFront.html.twig',array("categorie"=>$categorie,"outil"=>$outil));

    }
    public function mesOutilsAction(Request $request)
    {
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $mesOutils=$em->getRepository(UserOutil::class)->mesOutilsDQL($user);

        return $this->render("@Front/Outil/mesOutils.html.twig",array("mesOutils"=>$mesOutils));
    }

}
