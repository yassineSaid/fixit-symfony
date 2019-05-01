<?php

namespace WebServicesBundle\Controller;


use MainBundle\Entity\ServiceUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieService;
use MainBundle\Entity\Service;

class ServiceController extends Controller
{
    public function afficherWSAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieService::class)->findAll();
        $em1=$this->getDoctrine()->getManager();
        $service=$em1->getRepository(Service::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($service);
        return new JsonResponse($formatted);
    }
    public function afficherMesServicesWSAction($idUser)
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:ServiceUser");
        $su = $service->createQueryBuilder("q")
            ->where("q.idUser = :id")
            ->setParameter("id", $idUser)
            ->getQuery()
            ->getResult();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($su);
        return new JsonResponse($formatted);
    }
    public function getImageServiceWSAction($idService)
    {
        $em=$this->getDoctrine()->getManager();
        $image=$em->getRepository("MainBundle:ServiceUser")->serviceImage($idService);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($image);
        return new JsonResponse($formatted);
    }
    public function getAllCategorieWSAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieService::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse($formatted);
    }
    public function getServiceCategorieWSAction($idc)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository("MainBundle:ServiceUser")->serviceCategorie($idc);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse($formatted);
    }
}
