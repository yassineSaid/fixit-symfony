<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\ServicesProposes;
use MainBundle\Entity\ServiceUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Service;
use MainBundle\Entity\CategorieService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServiceController extends Controller
{
    public function afficherAction(Request $r)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categorie, /* query NOT result */
            $r->query->getInt('page', 1)/*page number*/,
            1/*limit per page*/
        );


        return $this->render('@Front/Service/listeCategorieService.html.twig',array("categorie"=>$categorie,"pagination"=>$pagination));
    }
    public function listerAction()
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:Service")->lister();

        return $this->render('@Front/Service/listeService.html.twig',array("service"=>$service));
    }
    public function detailsAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $service=$em->getRepository(Service::class)->find($id);
        $em->flush();
        return $this->render('@Front/Service/detailsService.html.twig',array("service"=>$service));
       // return $this->redirectToRoute("front_detailsService");

    }
    public function gererAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $service=$em->getRepository(Service::class)->findAll();
        $categorie=$em->getRepository(CategorieService::class)->findAll();
        $su=$em->getRepository("MainBundle:ServiceUser")->findServiceUserDql($this->getUser()->getId());
        $em->flush();
        return $this->render('@Front/User/gestionServiceUser.html.twig',array("service"=>$service,"categorie"=>$categorie,"su"=>$su));
        // return $this->redirectToRoute("front_detailsService");

    }
    public function listServiceCatAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $serv = $em->getRepository("MainBundle:Service");

        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $s = $serv->createQueryBuilder("q")
            ->where("q.CategorieService = :cat")
            ->setParameter("cat", $request->query->get("serviceid"))
            ->getQuery()
            ->getResult();

        $cnx = $this->getDoctrine()->getManager();
        $moyenne=$cnx->getRepository("MainBundle:ServiceUser")->moyennePrix();
        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
            $responseArray = array();
            foreach($s as $a){
                $responseArray[] = array(
                    "id" => $a->getId(),
                    "nom" => $a->getNom()
                );
            }

            // Return array with structure of the neighborhoods of the providen city id
            return new JsonResponse(array("services"=>$responseArray,"moyenne"=>$moyenne));

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }
    public function ajouterAction(Request $request)
    {
        $serviceUser = new ServiceUser();
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine()->getManager();
            $serviceUser->setIdUser($this->getUser());
            $serviceUser->setIdService($connexion1->getRepository("MainBundle:Service")->find($request->get("addService")));

            $serviceUser->setPrix($request->get("prix"));
            $em=$this->getDoctrine()->getManager();
            $em->persist($serviceUser);
            $em->flush();
            return $this->redirectToRoute("front_gererService");
        }
        return $this->render('@Front/Service/listeCategorieService.html.twig');
    }
    public function listeServiceUserAction(Request $request)
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:ServiceUser");
        $su = $service->createQueryBuilder("q")
            ->where("q.idUser = :id")
            ->setParameter("id", $request->query->get($this->getUser()->getId()))
            ->getQuery()
            ->getResult();
        return $this->render('@Front/User/gestionServiceUser.html.twig',array("service"=>$su));
    }
    public function supprimerAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $em->getRepository(ServiceUser::class)->supprimerServiceUserDQL($this->getUser()->getId(),$id);
        //$em->remove($serviceUser);
        //$em->flush();
        return $this->redirectToRoute("front_gererService");


    }
    public function ajouterPropositionAction(Request $request)
    {
        $proposition= new ServicesProposes();
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        if ($request->isMethod("POST"))
        {

            $proposition->setNomService($request->get("NomService"));
            $proposition->setCategorieService($request->get("IdCat"));
            $proposition->setDescription($request->get("DescriptionService"));

            $em=$this->getDoctrine()->getManager();
            $em->persist($proposition);
            $em->flush();

            return $this->redirectToRoute("front_proposerServiceUser");
        }

        return $this->render("@Front/Service/proposerService.html.twig",array("categorie"=>$categorie));


    }
    public function searchAction()
    {
        if(isset($_GET['search'])){
            $em=$this->getDoctrine()->getManager();
            $responseArray=$em->getRepository(CategorieService::class)->search();

            return new JsonResponse($responseArray);
        }
    }

}