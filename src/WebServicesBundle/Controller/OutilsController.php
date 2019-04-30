<?php

namespace WebServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieOutils;
use MainBundle\Entity\Outils;


class OutilsController extends Controller
{
    public function afficherWSAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        $em1=$this->getDoctrine()->getManager();
        $outil=$em1->getRepository(Outils::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($outil);
        return new JsonResponse($formatted);
    }
}
