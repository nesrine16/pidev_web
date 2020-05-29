<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $user=$this->getUser();
        return $this->render('@User/Default/homeuser.html.twig' ,array('user'=>$user));
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
