<?php


namespace AdminBundle\Controller;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\Fournisseur;
use UserBundle\Form\FournisseurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class FournisseurController extends Controller
{
    public function ajoutFournisseurAction(Request $request)
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //On recupere l'EntityManager
            $em = $this->getDoctrine()->getManager();
            //On persiste l'entite
            $em->persist($fournisseur);
            ///for the execution
            //On flush ce qui a ete persiste avant
            $em->flush();
//            dump($form->getErrors(true));
//            die();
            ///for showing redirection
            return $this->redirectToRoute("show_Fournisseur");
        }
        ///
        return $this->render("@Admin/Fournisseur/addFournisseur.html.twig", array(
            'form' => $form->createView()
        ));
    }


    public function ajoutFournisseurMobileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fournisseur = new Fournisseur();
        $fournisseur->setNomSociete($request->get('nomSociete'));
        $fournisseur->setCin($request->get('cin'));
        $fournisseur->setEmail($request->get('email'));
        $fournisseur->setAdresse($request->get('adresse'));
        $fournisseur->setTelephone($request->get('telephone'));
        $fournisseur->setFax($request->get('fax'));
        $em->persist($fournisseur);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($fournisseur);
        return new JsonResponse($formatted);
    }

    public function showFournisseurAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql=" SELECT p FROM UserBundle:Fournisseur p";
        $query= $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)
        );
        return $this->render('@Admin/Fournisseur/showFournisseur.html.twig', array("pagination" => $pagination
        ));
    }

    public function showFournisseurMobileAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:Fournisseur')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function RemoveFournisseurAction(Request $request)
    {

        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $fournisseur=$em->getRepository("UserBundle:Fournisseur")->find($id);
        $em->remove($fournisseur);
        $em->flush();
        return $this->redirectToRoute("show_Fournisseur");
    }

    public function deleteFournisseurMobileAction(Request $request){
        $id = $request->query->get('id');
        $fournisseur = $this->getDoctrine()->getRepository('UserBundle:Fournisseur')->find($id);
        if($fournisseur){
            $em = $this->getDoctrine()->getManager();
            $em->remove($fournisseur);
            $em->flush();
            $response = array("body"=> "Fournisseur supprimé");
        }else{
            $response = array("body"=>"Error");
        }
        return new JsonResponse($response);
    }

    public function updateFournisseurAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $fournisseur=$em->getRepository("UserBundle:Fournisseur")->find($id);
        $nomSociete=$fournisseur->getNomSociete();


        $form=$this->createForm(FournisseurType::class,$fournisseur);
        $form->handleRequest($request);
        if($form->isSubmitted()){


            $em->persist($fournisseur);
            $em->flush();
            return $this->redirectToRoute("show_Fournisseur");
        }
        return $this->render("@Admin/Fournisseur/updateFournisseur.html.twig",array(
            'form'=>$form->createView(),'fournisseur'=>$fournisseur ,"nomSociete"=>$nomSociete));
    }

    public function updateFournisseurMobileAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $fournisseur=$em->getRepository("UserBundle:Fournisseur")->find($id);
        $fournisseur->setNomSociete($request->get('nomSociete'));
        $fournisseur->setCin($request->get('cin'));
        $fournisseur->setAdresse($request->get('adresse'));
        $fournisseur->setEmail($request->get('email'));
        $fournisseur->setTelephone($request->get('telephone'));
        $fournisseur->setFax($request->get('fax'));

        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize(($fournisseur));
        return new JsonResponse($formatted);
    }

    public function mailAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $fournisseur = $em->getRepository("UserBundle:Fournisseur")->find($id);

        $message = \Swift_Message::newInstance()
            ->setSubject($request->get('subj'))
            ->setFrom('hanene.ennine@esprit.tn','smart truck')
            ->setTo('hanene.ennine@esprit.tn')
            ->setBody($request->get('description'));

        $this->get('mailer')->send($message);

        return $this->render("@Admin/Fournisseur/mailpage.html.twig",array(
            'fournisseur'=>$fournisseur
        ));
    }

    public function mailMobileAction (Request $request, $corps, $obj, $to){
        $em = $this->getDoctrine()->getManager();
        $message = \Swift_Message::newInstance()
            ->setSubject($obj)
            ->setFrom('hanene.ennine@esprit.tn','Smart Truck Application')
            ->setTo($to)
            ->setBody($corps);
        $this->get('mailer')->send($message);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($message);

        return new JsonResponse("success");
    }

    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:Fournisseur')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function RecherchCategorieAction(Request $request, $nom)
    {
        $em = $this->getDoctrine()->getManager();
        $nomSociete = new Fournisseur();
        $nomSociete = $em->getRepository('UserBundle:Fournisseur')->findBy($nom);

        return $this->render('@Produit/Front/Produit/produit.html.twig', array(
            "nomSociete" => $nomSociete
        ));
    }

    public function SearchByNomSocieteAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $code=$request->get('nomSociete');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository('UserBundle:Fournisseur')->findByNomSociete($code);
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);

        return new JsonResponse($formated);
    }
}