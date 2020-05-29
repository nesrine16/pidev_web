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

    public function deleteUtilisateurAction(Request $request){
        $id = $request->query->get('id');
        $utilisateur = $this->getDoctrine()->getRepository('UserBundle:utilisateur')->find($id);
        if($utilisateur){
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
            $response = array("body"=> "Utilisateur supprimé");
        }else{
            $response = array("body"=>"Error");
        }
        return new JsonResponse($response);
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

     public function SearchByNomAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $code=$request->get('username');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository('UserBundle:utilisateur')->findByUsername($code);
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);

        return new JsonResponse($formated);
    }

    public function getUserByIdAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:utilisateur')->findOneBy(array('id' => $id));
        $serializer = new Serializer([new ObjectNormalizer()]);
        return new JsonResponse($serializer->normalize($user));
    }

    public function getUserByUsernamePasswordAction(Request $request,$username,$password)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:utilisateur')->findBy(array('username' => $username));
        $user = $users[0];

        if ($user == null) return new JsonResponse(null);
        else {
            $passwordMatches = password_verify($password, $user->getPassword());
            if (!$passwordMatches) return new JsonResponse(null);
            else {
                $serializer = new Serializer([new ObjectNormalizer()]);
                return new JsonResponse($serializer->normalize($user));
            }
        }
    }

    public function mailAction(Request $request){
        $id=$request->get('id');
        $password=$request->get('password');
        $em = $this->getDoctrine()->getManager();
        $fournisseur = $em->getRepository("UserBundle:utilisateur")->find($id);

        $message = \Swift_Message::newInstance()
            ->setSubject($request->get('subj'))
            ->setFrom('hanene.ennine@esprit.tn','smart truck')
            ->setTo('hanene.ennine@esprit.tn')
            ->setBody($request->get('Votre mot de passe est'+$password));

        $this->get('mailer')->send($message);
        return $this->render("@Admin/Fournisseur/mailpage.html.twig",array(
            'fournisseur'=>$fournisseur
        ));

    }
}