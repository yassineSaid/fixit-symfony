<?php

namespace MainBundle\Controller;

use MainBundle\Entity\RealisationService;
use MainBundle\Entity\Reclamation;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReclamationController extends Controller
{
    public function AjouterReclamationAction(Request $request)
    {
        if ($this->getUser()==null)
        {
             return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(RealisationService::class)->findAll();
        $reclamation= new Reclamation();
        if($request->isMethod('POST'))
        {
            $iduser=intval($request->get("UserAReclamer"));
            $user=$em->getRepository(User::class)->find($iduser);
            $reclamation->setUserreclame($user);
            $reclamation->setObject($request->get("Object"));
            $reclamation->setDescription($request->get("Description"));
            $dater=new \DateTime();
            $reclamation->setDateReclamation($dater);
            $reclamation->setUser($this->getUser());
            $reclamation->setSeen(0);
            $reclamation->setTraite(0);
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('main_affiche_Detail_Reclamation',array("reclamation"=>$reclamation->getId()));
        }
        return $this->render('@Front/User/ajouterReclamation.html.twig',['user'=>$rec]);
    }

    public function AfficherDetailAction($reclamation)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($reclamation);
        return $this->render('@Front/User/detailsReclamation.html.twig',array("reclamation"=>$rec));
    }

    public function ModifierReclamationAction($rec,Request $request)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(RealisationService::class)->findAll();
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($rec);

        if($request->isMethod('POST'))
        {
            $iduser=intval($request->get("UserAReclamer"));
            $user=$em->getRepository(User::class)->find($iduser);
            $reclamation->setUserreclame($user);
            $reclamation->setObject($request->get("Object"));
            $reclamation->setDescription($request->get("Description"));
            $dater=new \DateTime();
            $reclamation->setDateReclamation($dater);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('main_affiche_Detail_Reclamation',array("reclamation"=>$reclamation->getId()));
        }
        return $this->render('@Front/User/modifierReclamation.html.twig',array("user"=>$user,"reclamation"=>$reclamation));
    }

    public function MesReclamationAction()
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $recs=$em->getRepository(Reclamation::class)->findReclamation($this->getUser()->getId());
        return $this->render('@Front/User/listReclamations.html.twig',array("reclamations"=>$recs));
    }

    public function SupprimerReclamationAction($rec)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($rec);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("main_mes_reclamation");
    }
    public function ListeReclamationAdminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->findAll();
        return $this->render('@Back/Reclamations/ListReclamationAdmin.html.twig',array("recs"=>$reclamation));

    }

    public  function detaillerecadminAction($rec)
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($rec);
        $rec->setSeen(1);
        $em->flush();
        return $this->render('@Back/Reclamations/detaillerec.html.twig',array("rec"=>$rec));
    }

    public function traiteadminAction($rec)
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($rec);
        $rec->setTraite(1);
        $userrec=$rec->getUserreclame();
        $user=$rec->getUser();
        $em->flush();
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')->setUsername('mustapha.benhajminyaoui@esprit.tn')->setPassword('icarus09626776');

        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject("Reclamation contre vous")
            ->setFrom(array('mustapha.benhajminyaoui@esprit.tn' => 'mustapha.benhajminyaoui@esprit.tn'))
            ->setTo(array($userrec->getEmail() => $userrec->getEmail()))// email du client pour teste replacer par son @
            ->addPart('Votre Réclamation a été bien traité . votre satisfaction est importante pour nous','text/html');
        $result = $mailer->send($message);



        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject("Reclamation contre vous")
            ->setFrom(array('mustapha.benhajminyaoui@esprit.tn' => 'mustapha.benhajminyaoui@esprit.tn'))
            ->setTo(array($user->getEmail() => $user->getEmail()))// email du client pour teste replacer par son @
            ->addPart('Quelqun a porté une plainte contre vous','text/html');
        $result = $mailer->send($message);
        return $this->redirectToRoute('main_liste_reclamation_admin');
        return $this->redirectToRoute('main_liste_reclamation_admin');


    }

    public function supprimeradminAction($rec)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($rec);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('main_liste_reclamation_admin');
    }


}
