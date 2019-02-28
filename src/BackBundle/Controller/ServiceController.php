<?php

namespace BackBundle\Controller;

use MainBundle\Entity\CategorieService;
use MainBundle\Entity\HistoriqueService;
use MainBundle\Entity\ServicesProposes;
use MainBundle\Repository\HistoriqueServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Service;

class ServiceController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $service = new Service();
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $service->setNom($request->get("Nom"));
            $service->setCategorieService($connexion1->getRepository("MainBundle:CategorieService")->find($request->get("IdCat")));
            $service->setNbrProviders(0);
            $service->setVisible(1);
            $service->setDescription($request->get("Nom"));
            $file=$request->files->get("image");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $service->setImageService($fileName);
            $file->move(
                $this->getParameter('service_directory'),
                $fileName
            );
            $em=$this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute("back_ajouterService");
        }
        return $this->render('@Back/Service/ajouterService.html.twig',array("categorie"=>$categorie));
    }
    public function afficherAction()
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:Service")->afficherBack();
        return $this->render('@Back/Service/afficherService.html.twig',array("service"=>$service));
    }
    public function modifierAction(Request $r,$id)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $em=$this->getDoctrine()->getManager();
        $service=$em->getRepository(Service::class)->find($id);
        if ($r->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $service->setNom($r->get("Nom"));
            $service->setCategorieService($connexion1->getRepository("MainBundle:CategorieService")->find($r->get("IdCat")));
            $image = $service->getImageService();
            if($image!=null)
            {unlink($this->getParameter('service_directory').'/'.$image);}
            $file=$r->files->get("image");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $service->setImageService($fileName);
            $file->move(
                $this->getParameter('service_directory'),
                $fileName
            );
            $em->flush();
            return $this->redirectToRoute("back_afficherService");
        }
        return $this->render("@Back/Service/modifierService.html.twig",array("service"=>$service,"categorie"=>$categorie));

    }
    public function supprimerAction(Request $r,$id)
    {
        /*$em=$this->getDoctrine()->getManager();
        $service=$em->getRepository(Service::class)->find($id);
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute("back_afficherService");*/
        $cnx=$this->getDoctrine()->getManager();
        $historique=new HistoriqueService();

        $em=$this->getDoctrine()->getManager();
        $service=$em->getRepository(Service::class)->find($id);
       // if($r->isMethod("POST"))
       // {
        $historique->setIdService($service->getId());
        $historique->setNomService($service->getNom());
        $historique->setCategorieService("test");
        $historique->setDateSuppression(new \DateTime);
        $historique->setActions("supprimé");
        $cnx->persist($historique);
        $cnx->flush();

            $service->setVisible(0);
            $em->flush();
           return $this->redirectToRoute("back_afficherService");
       // }

        return $this->render("@Back/Service/afficherService.html.twig",array("service"=>$service));

    }
    public function afficherPropositionAction()
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:ServicesProposes")->findAll();
        return $this->render('@Back/Service/servicesProposes.html.twig',array("serviceProposes"=>$service));
    }
    public function etudierPropositionAction($id)
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:ServicesProposes")->find($id);
        $connexion1=$this->getDoctrine();
        $cat=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        return $this->render('@Back/Service/etudeProposition.html.twig',array("service"=>$service,"categorie"=>$cat));
    }
    public function ajouterPropositionAction(Request $request,$id)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $service = new Service();
        if ($request->isMethod("POST"))
        {
        var_dump($request->get("nom"));
            $connexion1=$this->getDoctrine();
            $service->setNom($request->get("nom"));
            $service->setDescription($request->get("description"));
            $service->setCategorieService($connexion1->getRepository("MainBundle:CategorieService")->find($request->get("IdCat")));
            $service->setNbrProviders(0);
            $service->setVisible(1);
            $file=$request->files->get("image");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $service->setImageService($fileName);
            $file->move(
                $this->getParameter('service_directory'),
                $fileName
            );
            $em=$this->getDoctrine()->getManager();
            var_dump($service);

            $cnx=$this->getDoctrine()->getManager();
            $prop=$cnx->getRepository(ServicesProposes::class)->find($id);

            $cnx->remove($prop);

            $cnx->flush();
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute("back_afficherService");
        }
        return $this->render('@Back/Service/etudeProposition.html.twig',array("categorie"=>$categorie));
    }
    public function afficherHistoriqueAction()
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:HistoriqueService")->findAll();
        return $this->render('@Back/Service/historiqueService.html.twig',array("historique"=>$service));
    }
    public function recupererHistoriqueAction($idh,$id)
    {
        $connexion=$this->getDoctrine()->getManager();
        $em=$this->getDoctrine()->getManager();
       $historique=$em->getRepository(HistoriqueService::class)->find($idh);
       $historique->setActions("Récupéré");

        //if($r->isMethod("POST"))
        //{
        $service=$connexion->getRepository(Service::class)->find($id);
        $service->setVisible(1);
        $connexion->flush();
        return $this->redirectToRoute("back_afficherService");
        //}
        //return $this->render('@Back/Service/afficherService.html.twig');
    }
    public function SupprimerPropositionAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(ServicesProposes::class)->find($id);

        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("back_afficherServiceProposes");
    }

}
