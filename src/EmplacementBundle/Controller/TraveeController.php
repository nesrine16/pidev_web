<?php

namespace EmplacementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TraveeController extends Controller
{

    public function getListTraveeAction($numTrav,$idA)
    {
        $ser = new Serializer([new ObjectNormalizer()]);
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT IDENTITY (u.idEmp) AS idEmp,u.id,u.numTrav,IDENTITY (u.allee) AS allee FROM EmplacementBundle:Travee u ,EmplacementBundle:Allee a 
        WHERE a.id = ?1 AND u.numTrav = ?2 and a.id=u.allee');
        $query->setParameter(1, $idA);
        $query->setParameter(2, $numTrav);
        $uu = $query->getResult();

        $formated = $ser->normalize($uu);


        return new JsonResponse($formated);

    }



}
