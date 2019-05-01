<?php

namespace WebServicesBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserController extends Controller
{
    public function getUserAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->getPassword($request->get("email"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function getUsersAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $users=$connect->getRepository(User::class)->listUsers($request->get("nom"),"");
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);
    }
    public function getUserByIdAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->find($request->get("id"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function getUserByUsernameAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->getUsername($request->get("username"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function getUserByEmailAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->getEmail($request->get("email"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function modifierUserAction(Request $request)
    {
        if ($request->isMethod("post")) {
            $connect = $this->getDoctrine()->getManager();
            $user = $connect->getRepository(User::class)->find($request->get("id"));
            $user->setFirstname($request->get("firstname"));
            $user->setLastname($request->get("lastname"));
            $user->setAddress($request->get("address"));
            $user->setZipCode($request->get("zipCode"));
            $user->setPhone($request->get("phone"));
            $user->setCity($request->get("city"));
            $connect->persist($user);
            $connect->flush();
            return new JsonResponse(200);
        }
        return new JsonResponse(500);
    }
    public function modifierSoldeUserAction(Request $request)
    {
        if ($request->isMethod("post")) {
            $connect = $this->getDoctrine()->getManager();
            $user = $connect->getRepository(User::class)->find($request->get("id"));
            $user->setSolde($request->get("montant"));
            $connect->persist($user);
            $connect->flush();
            return new JsonResponse(200);
        }
        return new JsonResponse(500);
    }
    public function inscriptionUserAction(Request $request)
    {
        if ($request->isMethod("post")) {
            $connect = $this->getDoctrine()->getManager();
            //$user = $connect->getRepository(User::class)->find($request->get("id"));
            $user = new User();
            $user->setEmail($request->get("email"));
            $user->setEmailCanonical($request->get("email_canonical"));
            $user->setUsername($request->get("username"));
            $user->setUsernameCanonical($request->get("username_canonical"));
            $user->setPassword($request->get("password"));
            $user->setSolde(0);
            $user->setEnabled(1);
            $user->addRole('ROLE_USER');
            $user->setFirstname($request->get("firstname"));
            $user->setLastname($request->get("lastname"));
            $user->setAddress($request->get("address"));
            $user->setZipCode($request->get("zipCode"));
            $user->setPhone($request->get("phone"));
            $user->setCity($request->get("city"));
            $connect->persist($user);
            $connect->flush();
            return new JsonResponse(200);
        }
        return new JsonResponse(500);
    }
}
