<?php

namespace UserBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Livraison;

class LivraisonController extends Controller
{
    public function ajoutAction(Request $request){
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $livraison->setChefId($this->getUser());
           // $livraison->setNom($request->get('nom'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            return $this->redirectToRoute("livraison_listmy");
        }
        return $this->render("@User/livraison/add_livraison.html.twig",array(
            'form'=>$form->createView(),'livraison'=>$livraison
        ));

    }
    public function deleteAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $livraison = $em->getRepository("UserBundle:Livraison")->find($id);
        $em->remove($livraison);
        $em->flush();
        return $this->redirectToRoute("livraison_listmy");

    }

    public function listmyAction(){
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT l FROM UserBundle:Livraison l WHERE l.chefId=:id ");
        $query->setParameter('id',$id);
        $livraisons = $query->getResult();
        $nb=count($livraisons);
        return $this->render("@User/livraison/listmy_livraison.html.twig",array(
            'livraisons'=>$livraisons,'nb'=>$nb
        ));
    }

    public function updateAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $livraison=$em->getRepository("UserBundle:Livraison")->find($id);
        $livreur=$livraison->getLivreur();

        $form=$this->createForm(LivraisonType::class,$livraison);
        $form->handleRequest($request);
        if($form->isSubmitted()){

            $em->persist($livraison);
            $em->flush();
            return $this->redirectToRoute("livraison_listmy");
        }
        return $this->render("@User/livraison/updateLivraison.html.twig",array(
            'form'=>$form->createView(),'livraison'=>$livraison ,"livreur"=>$livreur));
    }
}
