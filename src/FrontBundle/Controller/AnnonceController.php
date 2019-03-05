<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\Annonce;
use MainBundle\Entity\RealisationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\User;
use MainBundle\Entity\Candidature;
use Symfony\Component\HttpFoundation\JsonResponse;
class AnnonceController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $nbro=$connexion->getRepository("MainBundle:Annonce")->nbrOff();
        $nbrd=$connexion->getRepository("MainBundle:Annonce")->nbrDem();
        $service=$connexion->getRepository("MainBundle:Service")->findAll();
        $annonce = new annonce();
        if ($request->isMethod("POST"))
        {
            var_dump($nbro);
            $em=$this->getDoctrine()->getManager();
            $connexion1=$this->getDoctrine();
            $connexion2=$this->getDoctrine();
            $iduser=$this->getUser()->getId();
            $user=$em->getRepository(User::class)->find($iduser);
            $annonce->setUser($user);
            $annonce->setNbrC(0);

            $annonce->setType($request->get("type"));
            if($request->get("type")=="demande")
            {
                $annonce->setNbrO(intval($nbro[0][1]));
                $annonce->setNbrD(intval($nbrd[0][1])+1);
            }
            if($request->get("type")=="offre")
            {
                $annonce->setNbrO(intval($nbro[0][1])+1);
                $annonce->setNbrD(intval($nbrd[0][1]));
            }

            $annonce->setPrix($request->get("prix"));
            $annonce->setDescription($request->get("description"));
            $annonce->setAdresse($request->get("adresse"));
            $annonce->setDate(new \DateTime($request->get("date")));
            $annonce->setTel($request->get("tel"));
            $annonce->setCategorieService($connexion1->getRepository("MainBundle:CategorieService")->find($request->get("CategorieService")));
            $annonce->setService($connexion2->getRepository("MainBundle:Service")->find($request->get("IdService")));
            $em=$this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute("mesAnnonces");
        }
        return $this->render('@Front/Annonce/ajouter.html.twig',array("categorie"=>$categorie,"service"=>$service));
    }

    public function listeOffreAction(Request $r)
    {
        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->offAnnonce();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonce, /* query NOT result */
            $r->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render('@Front/Annonce/liste.html.twig',array("annonce"=>$annonce,"pagination"=>$pagination));
    }

    public function listeDemAction(Request $r)
    {
    $em=$this->getDoctrine()->getManager();
    $annonce=$em->getRepository(Annonce::class)->demAnnonce();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonce, /* query NOT result */
            $r->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
    return $this->render('@Front/Annonce/listeDem.html.twig',array("annonce"=>$annonce,"pagination"=>$pagination));
    }

    public function modifierAction(Request $request, $id)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $service=$connexion->getRepository("MainBundle:Service")->findAll();
        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->find($id);
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $connexion2=$this->getDoctrine();
            $annonce->setPrix($request->get("prix"));
            $annonce->setDescription($request->get("description"));
            $annonce->setAdresse($request->get("adresse"));
            $annonce->setTel($request->get("tel"));
            $annonce->setType($request->get("type"));
            $dater=new \DateTime();
            $annonce->setDate($dater);
            $annonce->setCategorieService($connexion1->getRepository("MainBundle:CategorieService")->find($request->get("CategorieService")));
            $annonce->setService($connexion2->getRepository("MainBundle:Service")->find($request->get("service")));
            $em->flush();
            return $this->redirectToRoute("mesAnnonces");
        }
        return $this->render("@Front/Annonce/modifier.html.twig",array("annonce"=>$annonce,"categorie"=>$categorie,"service"=>$service));
    }

    public function supprimerAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->find($id);
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute("mesAnnonces");
    }

    public function mesAnnoncesAction()
    {
        $em=$this->getDoctrine()->getManager();
        $annonces=$em->getRepository(Annonce::class)->findAnnonce($this->getUser()->getId());
        return $this->render('@Front/Annonce/mesAnnonces.html.twig',array("annonce"=>$annonces));
    }

    public function detailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $em1=$this->getDoctrine()->getRepository(Annonce::class);
        $val=$em1->countC($id);
        $annonce=$em->getRepository(Annonce::class)->find($id);
        $annonce->setNbrC($val);
        return $this->render('@Front/Annonce/detail.html.twig',array("annonce"=>$annonce));
    }

    public function candidatAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->find($id);

        return $this->render('@Front/Annonce/listeCandidats.html.twig',array("annonce"=>$annonce));
    }

    public function confirmerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $em1=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->findByIdJoinedToCategory();
        $idA=$em1->getRepository(Annonce::class)->find($id);
        $em->getRepository(Annonce::class)->confirmer($id,$idA);
        $userCandidature=$em->getRepository(Candidature::class)->find($id);
        $conntect=$this->getDoctrine()->getManager();
        //if($conntect->getRepository(User::class)->payerService($idA,$id,$annonce[0]->getPrix()))
        {
            $realisation=new RealisationService();
            if($annonce[0]->getType()=="demande")
            {
                $realisation->setService($annonce[0]->getService());
                $realisation->setUserDemandeur($annonce[0]->getUser());
                $realisation->setUserOffreur($userCandidature->getUser());
                $realisation->setDateRealisation($annonce[0]->getDate());
            }
            else if($annonce[0]->getType()=="offre")
            {
                $realisation->setService($annonce[0]->getService());
                $realisation->setUserDemandeur($userCandidature->getUser());
                $realisation->setUserOffreur($annonce[0]->getUser());
                $realisation->setDateRealisation($annonce[0]->getDate());
            }

            $em->persist($realisation);
            $em->flush();
        }
        return $this->redirectToRoute('mesAnnonces');
    }
    public function gestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $serv = $em->getRepository("MainBundle:Service");

        $s = $serv->createQueryBuilder("q")
            ->where("q.CategorieService = :cat")
            ->setParameter("cat", $request->query->get("serviceid"))
            ->getQuery()
            ->getResult();

        $responseArray = array();
        foreach($s as $a){
            $responseArray[] = array(
                "id" => $a->getId(),
                "nom" => $a->getNom()
            );
        }

        return new JsonResponse(array("services"=>$responseArray));
    }
}
