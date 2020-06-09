<?php

namespace AdminBundle\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('UserBundle:Commande')->findAll();

        return $this->render('@Admin/commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**mobile
     *
     */

    public function commandeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $rep = $em->getRepository('UserBundle:Commande')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rep);
        return new JsonResponse($formatted);
    }

    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(Commande $commande)
    {
        return $this->render('@Admin/commande/show.html.twig', array(
            'commande' => $commande,
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {
        $editForm = $this->createForm('UserBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request); // récuperer les information de formaulaire

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_commande_edit', array('id_commande' => $commande->getIdCommande()));
        }

        return $this->render('@Admin/commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     */
    public function deleteAction(Request $request, Commande $commande)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();


        return $this->redirectToRoute('admin_commande_index');
    }

    public function envoyerMailAction(Commande $commande)
    {
        $etatCommande = $commande->getEtat();

        if ($etatCommande == 'validée') {
            $view = $this->renderView('@Admin/commande/email_validee.html.twig', array(
                'commande' => $commande
            ));
        } else {
            $view = $this->renderView('@Admin/commande/email_rejetee.html.twig');
        }

        $message = \Swift_Message::newInstance('Votre commande')
            ->setFrom('nesrine2020esprit@gmail.com')
            ->setTo('nesrine2020esprit@gmail.com')
            ->setBody(
                $view,
                'text/html'
            );

        $this->get('mailer')->send($message);

        return $this->redirectToRoute('admin_commande_index');
    }

    public function pdfAction(Commande $commande)
    {

        $html = $this->render('@Admin/commande/pdf.html.twig', array(
            'commande' => $commande,
        ))->getContent();

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'commande-'.$commande->getIdCommande().'.pdf'
        );
    }
}
