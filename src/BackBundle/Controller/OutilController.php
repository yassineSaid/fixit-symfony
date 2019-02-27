<?php

namespace BackBundle\Controller;

use MainBundle\Entity\HistoriqueLocation;
use MainBundle\Entity\User;
use MainBundle\Entity\UserOutil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieOutils;
use MainBundle\Entity\Outils;

class OutilController extends Controller
{
    public function ajouterAction(Request $request)
    {

        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieOutils")->findAll();
        $outil = new Outils();
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $outil->setNom($request->get("inputNom"));
            $outil->setQuantite($request->get("inputQuantite"));
            $outil->setDureeMaximale($request->get("inputDuree"));
            $outil->setPrix($request->get("inputPrix"));
            $outil->setAdresse($request->get("inputAdresse"));
            $outil->setCodePostal($request->get("inputCodePostal"));
            $outil->setVille($request->get("inputVille"));
            $outil->setCategorieOutils($connexion1->getRepository("MainBundle:CategorieOutils")->find($request->get("inputCategorie")));
            $file=$request->files->get("inputImage");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $outil->setImage($fileName);
            $file->move(
                $this->getParameter('outil_directory'),
                $fileName
            );
            $em=$this->getDoctrine()->getManager();
            $em->persist($outil);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("back_listOutil");
        }
        return $this->render('@Back/Outil/ajouter.html.twig',array("categorie"=>$categorie));
    }
    public function ListeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->findAll();
        return $this->render('@Back/Outil/list.html.twig',array("outil"=>$outil));

    }
    public function modifierAction(Request $request)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieOutils")->findAll();
        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $outil->setNom($request->get("inputNom"));
            $outil->setQuantite($request->get("inputQuantite"));
            $outil->setDureeMaximale($request->get("inputDuree"));
            $outil->setPrix($request->get("inputPrix"));
            $outil->setAdresse($request->get("inputAdresse"));
            $outil->setCodePostal($request->get("inputCodePostal"));
            $outil->setVille($request->get("inputVille"));
            $outil->setCategorieOutils($connexion1->getRepository("MainBundle:CategorieOutils")->find($request->get("inputCategorie")));
            if($request->get("inpuImage")!=null)
            {
                $image = $outil->getImage();
                if($image!=null)
                {unlink($this->getParameter('outil_directory').'/'.$image);}
                $file=$request->files->get("inputImage");
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $outil->setImage($fileName);
                $file->move(
                    $this->getParameter('outil_directory'),
                    $fileName
                );
            }
            $em->flush();
            return $this->redirectToRoute("back_listOutil");
        }
        return $this->render("@Back/Outil/modifier.html.twig",array("outil"=>$outil,"categorie"=>$categorie));
    }
    public function SupprimerAction(Request $request)
    {
        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        $image = $outil->getImage();
        if($image!=null)
        {unlink($this->getParameter('outil_directory').'/'.$image);}
        $em->remove($outil);
        $em->flush();
        return $this->redirectToRoute("back_listOutil");
    }
    public function outilLouesAction()
    {
        $em=$this->getDoctrine()->getManager();
        $userOutil=$em->getRepository(UserOutil::class)->findAll();
        return $this->render('@Back/Outil/outilLoues.html.twig',array("userOutil"=>$userOutil));

    }
    public function retournerAction()
    {
        $idOutil=$_GET['idOutil'];
        $idUser=$_GET['idUser'];
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($idOutil);
        $em6=$this->getDoctrine()->getManager();
        $user=$em6->getRepository(User::class)->find($idUser);
        $outil->setQuantite($outil->getQuantite()+1);
        $em1=$this->getDoctrine()->getManager();
        $userOutil=$em1->getRepository(UserOutil::class)->location($idOutil,$idUser);
        $em2=$this->getDoctrine()->getManager();
        $historique=new HistoriqueLocation();
        $historique->setIdOutil($idOutil);
        $historique->setIdUser($idUser);
        $historique->setDateLocation($userOutil[0]->getDateLocation());
        $historique->setDateRetour($userOutil[0]->getDateRetour());
        $historique->setTotal($userOutil[0]->getTotal());
        $em4=$this->getDoctrine()->getManager();
        $notification= $em4->getRepository('MainBundle:Notification')->findNotification($outil,$user);
        if($notification!=null)
        {
            $em4->remove($notification[0]);
            $em->flush();
        }
        $em2->persist($historique);
        $em2->flush();
        $em1->remove($userOutil[0]);
        $em1->flush();
        return $this->redirectToRoute("back_outilLoues");
    }
    public function historiqueAction()
    {
        $em=$this->getDoctrine()->getManager();
        $historique=$em->getRepository(HistoriqueLocation::class)->findAll();
        $em1=$this->getDoctrine()->getManager();
        $outil=$em1->getRepository(Outils::class)->findAll();
        $em2=$this->getDoctrine()->getManager();
        $user=$em2->getRepository(User::class)->findAll();
        return $this->render('@Back/Outil/historique.html.twig',array("outil"=>$outil,"historique"=>$historique,"user"=>$user));

    }



}
