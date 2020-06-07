<?php

namespace AdminBundle\Controller;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\Livreur;
use UserBundle\Form\LivreurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class LivreurController extends Controller
{

    public function ajoutLivreurAction(Request $request)
    {

        $livreur = new Livreur();
        $form = $this->createForm(LivreurType::class, $livreur);
        ///Pour recuperer les entrees de la form comme post dans le
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {

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

    public function ajoutLivreurMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $livreur = new Livreur();
        $livreur->setNom($request->get('nom'));
        $livreur->setPrenom($request->get('prenom'));
        $livreur->setVille($request->get('ville'));
        $livreur->setTelephone($request->get('telephone'));
        $em->persist($livreur);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($livreur);
        return new JsonResponse($formatted);
    }

    public function showLivreurAction(Request $request)
    {
        //create our entity manager: get the service doctrine
        $em = $this->getDoctrine()->getManager();
        $dql=" SELECT p FROM UserBundle:Livreur p";
        $query= $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)
        );
        return $this->render('@Admin/Livreur/showLivreur.html.twig', array("pagination" => $pagination
        ));
    }

    public function showLivreurMobAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:Livreur')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
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

    public function deleteLivreurMobileAction(Request $request){
        $id = $request->query->get('id');
        $livreur = $this->getDoctrine()->getRepository('UserBundle:Livreur')->find($id);
        if($livreur){
            $em = $this->getDoctrine()->getManager();
            $em->remove($livreur);
            $em->flush();
            $response = array("body"=> "Livreur supprimé");
        }else{
            $response = array("body"=>"Error");
        }
        return new JsonResponse($response);
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

    public function updateLivreurMobileAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $livreur=$em->getRepository("UserBundle:Livreur")->find($id);
        $livreur->setNom($request->get('nom'));
        $livreur->setPrenom($request->get('prenom'));
        $livreur->setVille($request->get('ville'));
        $livreur->setTelephone($request->get('telephone'));

        $em->persist($livreur);
        $em->flush();
        return new JsonResponse("success");
    }

    public function SearchByNomAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $code=$request->get('nom');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository('UserBundle:Livreur')->findByNom($code);
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);

        return new JsonResponse($formated);
    }

    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:Livreur')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

}