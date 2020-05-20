<?php

namespace AdminBundle\Controller;
use UserBundle\Entity\Livreur;
use UserBundle\Form\LivreurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LivreurController extends Controller
{

    public function ajoutLivreurAction(Request $request)
    {

        $livreur = new Livreur();
        $form = $this->createForm(LivreurType::class, $livreur);
        ///Pour recuperer les entrees de la form comme post dans le
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            //On recupere l'EntityManager
            $em = $this->getDoctrine()->getManager();
            //On persiste l'entite
            $em->persist($livreur);
            ///for the execution
            //On flush ce qui a ete persiste avant
            $em->flush();
//            dump($form->getErrors(true));
//            die();
            ///for showing redirection
            return $this->redirectToRoute("show_Livreur");
        }
        ///
        return $this->render("@Admin/Livreur/addLivreur.html.twig", array(
            'form' => $form->createView()
        ));

    }

    public function showLivreurAction()
    {
        //create our entity manager: get the service doctrine
        $em = $this->getDoctrine();
        //repository help you fetch (read) entities of a certain class.
        $repository = $em->getRepository(Livreur::class);
        //find *all* 'Projet' objects
        $livreurs = $repository->findAll();
        //render a template with the list of objects
        return $this->render('@Admin/Livreur/showLivreur.html.twig', array(
            'livreurs' => $livreurs
        ));
    }

    public function RemoveLivreurAction(Request $request)
    {

        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $livreur=$em->getRepository("UserBundle:Livreur")->find($id);
        $em->remove($livreur);
        $em->flush();
        return $this->redirectToRoute("show_Livreur");
    }

    public function updatelivreurAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $livreur=$em->getRepository("UserBundle:Livreur")->find($id);
        $nom=$livreur->getNom();


        $form=$this->createForm(LivreurType::class,$livreur);
        $form->handleRequest($request);
        if($form->isSubmitted()){


            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute("show_Livreur");
        }
        return $this->render("@Admin/Livreur/updateLivreur.html.twig",array(
            'form'=>$form->createView(),'livreur'=>$livreur ,"nom"=>$nom));
    }
}