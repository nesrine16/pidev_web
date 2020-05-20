<?php


namespace AdminBundle\Controller;
use UserBundle\Entity\Fournisseur;
use UserBundle\Form\FournisseurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FournisseurController extends Controller
{
    public function ajoutFournisseurAction(Request $request)
    {

        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

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

    public function showFournisseurAction()
    {
        //create our entity manager: get the service doctrine
        $em = $this->getDoctrine();
        //repository help you fetch (read) entities of a certain class.
        $repository = $em->getRepository(Fournisseur::class);
        //find *all* 'Projet' objects
        $fournisseurs = $repository->findAll();
        //render a template with the list of objects
        return $this->render('@Admin/Fournisseur/showFournisseur.html.twig', array(
            'fournisseurs' => $fournisseurs
        ));
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

    public function mailAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $fournisseur = $em->getRepository("UserBundle:Fournisseur")->find($id);


//        if($request->isMethod('POST')){
        $message = \Swift_Message::newInstance()
            ->setSubject($request->get('subj'))
            ->setFrom('hanene.ennine@esprit.tn','smart truck')
            ->setTo('hanene.ennine@esprit.tn')
            ->setBody($request->get('description'));


        $this->get('mailer')->send($message);

//        }


        return $this->render("@Admin/Fournisseur/mailpage.html.twig",array(
            'fournisseur'=>$fournisseur
        ));

    }
}