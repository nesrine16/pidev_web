<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getManager();
//
        $user=$this->getUser();
//        $id=$user->getId();
//        $etat = 0;
//        $CMD1 = $em->getRepository("UserBundle:Commande")->findOneBy(array("idUser" => $user, "etat" => $etat));
//
//        $query=$em->createQuery("select p from UserBundle:Panier p join UserBundle:Commande c with c.idCmd =p.idcommande where c.idUser=:id");
//        $query->setParameter('id',$id);
//
//        $panier= $query->getResult();

        return $this->render('@User/Default/homeuser.html.twig' ,array('user'=>$user));
    }

    public  function mapAction(){
        return $this->render('@User/Default/newMap.html.twig');


    }

    public function loginAction($username,$password)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u
             FROM UserBundle:utilisateur u        
             WHERE u.username = :username
             AND u.password like :password'

        )->setParameters(array(
                'username'=>$username,
                'password'=>$password.'%')
        );

        $user = $query->getResult();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    /*
     * recuperation mot de passe mobile
     */
    public function forgetPasswordAction($username)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u
             FROM UserBundle:utilisateur u        
             WHERE u.username = :username'

        )->setParameter(
            'username',$username
        );

        $user = $query->getResult();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }


}
