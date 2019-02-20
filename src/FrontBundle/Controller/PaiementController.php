<?php

namespace FrontBundle\Controller;
use MainBundle\Entity\Paiement;
use MainBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaiementController extends Controller
{
    public function paiementAction(Request $request)
    {
        if (isset($_POST['app']))
        {
            $date=new \DateTime();
            \Stripe\Stripe::setApiKey("sk_test_rkfr2kuDbj8a7LRmarLt40W7");
            \Stripe\Charge::create([
                "amount" => $_POST["scoin"],
                "currency" => "usd",
                "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
                "description" => "Paiement pour l'utilisateur id=".$this->getUser()->getID()
            ]);
            $connect=$this->getDoctrine()->getManager();
            $connect1=$this->getDoctrine()->getManager();
            $user=$connect->getRepository(User::class)->find($this->getUser()->getID());
            $user->setSolde($user->getSolde()+$_POST["scoin"]*2/100);
            $connect->flush();
            $paiement=new Paiement();
            $paiement->setIdUser($this->getUser());
            $paiement->setMontant($_POST["scoin"]/100);
            $paiement->setNombreScoin($_POST["scoin"]*2/100);
            $paiement->setDatePaiement($date);
            $paiement->setStripeToken($request->request->get('stripeToken'));
            $connect1->persist($paiement);
            $connect1->flush();
            return $this->render('@Front/Paiement/merci.html.twig');
        }
        else return $this->render('@Front/Paiement/paiement.html.twig',array("scoin"=>$_POST["scoin"]/2));
    }
    public function listeAction()
    {
        $connect=$this->getDoctrine()->getManager();
        $paiements=$connect->getRepository(Paiement::class)->paiementsUser($this->getUser()->getId());
        return $this->render('@Front/Paiement/historiquePaiement.html.twig',array('paiements'=>$paiements));
    }
}
