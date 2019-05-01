<?php

namespace WebServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Produit;

class ProduitsController extends Controller
{
    public function afficherWSAction(Request $request)
    {
        $user=$request->get('idUser');
        $em1=$this->getDoctrine()->getManager();
        $produit=$em1->getRepository(Produit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }
    public function MesProduitsWSAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Produit::class)->mesProduitsDQL($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prod);
        return new JsonResponse($formatted);
    }
}
