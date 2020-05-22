<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\utilisateur;

class utilisateurController extends Controller
{
    public function ajoutUtilisateurAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = new utilisateur();
        $utilisateur->setNom($request->get('nom'));
        $utilisateur->setPrenom($request->get('prenom'));
        $utilisateur->setAdresse($request->get('adresse'));
        $utilisateur->setTelephone($request->get('telephone'));
        $utilisateur->setEmail($request->get('email'));
        $utilisateur->setGrade($request->get('grade'));
        $utilisateur->setUsername($request->get('username'));
        $utilisateur->setPassword($request->get('password'));
        $em->persist($utilisateur);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($utilisateur);
        return new JsonResponse($formatted);
    }


      public function showUtilisateurAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:utilisateur')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }



      public function updateUtilisateurMobileAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $utilisateur=$em->getRepository("UserBundle:utilisateur")->find($id);
        $utilisateur->setNom($request->get('nom'));
        $utilisateur->setPrenom($request->get('prenom'));
        $utilisateur->setAdresse($request->get('adresse'));
        $utilisateur->setTelephone($request->get('telephone'));
        $utilisateur->setEmail($request->get('email'));
        $utilisateur->setRole($request->get('role'));
        $utilisateur->setUsername($request->get('username'));
        $utilisateur->setPassword($request->get('password'));

            $em->persist($utilisateur);
            $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($utilisateur);
        return new JsonResponse($formatted);
    }


    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:utilisateur')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }


}