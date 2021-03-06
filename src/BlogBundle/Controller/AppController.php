<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Commentaires;


class AppController extends Controller
{
    /**
     * @Route("/", name="accueil")
     */
    public function indexAction(Request $request)
    {
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        // replace this example code with whatever you need
        foreach ($projets as $projet){
            $resume = $projet->getResume();
            $html = $this->getDoctrine()->getRepository('BlogBundle:Projet')->getExtraitProjet($resume);
            $projet->setResume($html);
    }
        $form = $this->createForm('BlogBundle\Form\ContactType',null,array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('accueil'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $decode = $this->get('app.recaptcha')->verifCaptcha();
            if($decode['success'] === true){
                $this->get('app.email')->sendEmail($form->getData());
            }
            else {
                $request->getSession()->getFlashBag()->add('Erreur', 'Vous devez cocher la case "je ne suis pas un robot" pour envoyer un message.');
            }
            return $this->redirectToRoute('accueil');
        }
        return $this->render('index.html.twig', [
            'projets' => $projets,
            'html' => $html,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/projet/{idProjet}",name="projet_cate", requirements={"idProjet": "\d+"})
     */
    public function projetAction($idProjet,Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($idProjet);
        $projet = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findOneById($idProjet);
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();

        return $this->render('projet.html.twig', [
            'categories' => $categories,
            'projet' => $projet,
            'projets' => $projets,
        ]);

    }

    /**
     * @Route("/projet/last", name="projet_last")
     */
    public function lastAction(Request $request)
    {
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        $articles = $this->getDoctrine()->getRepository('BlogBundle:Articles')->findLast();
        $commentaires = $this->getDoctrine()->getRepository('BlogBundle:Commentaires')->findAll();
        $newCommentaire = new Commentaires();
        $form = $this->createForm('BlogBundle\Form\CommentairesType', $newCommentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $decode = $this->get('app.recaptcha')->verifCaptcha();
            if($decode['success'] === true){
                $em = $this->getDoctrine()->getManager();
                $em->persist($newCommentaire);
                $em->flush($newCommentaire);
            }
            else {
                $request->getSession()->getFlashBag()->add('Erreur', 'Vous devez cocher la case "je ne suis pas un robot" avant de valider un commentaire.');
            }
            return $this->redirectToRoute('projet_last');
        }
        return $this->render(':projet:last.html.twig', [
           'articles' => $articles,
            'projets' => $projets,
            'commentaires' => $commentaires,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/projet/{idProjet}/categorie/{idCate}", name="projet_categorie_articles")
     */
    public function categorieAction($idCate,$idProjet,Request $request)
    {
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        $commentaires = $this->getDoctrine()->getRepository('BlogBundle:Commentaires')->findAll();
        $articles = $this->getDoctrine()->getRepository('BlogBundle:Articles')->findByCategorie($idCate);
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($idProjet);
        $newCommentaire = new Commentaires();
        $form = $this->createForm('BlogBundle\Form\CommentairesType', $newCommentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $decode = $this->get('app.recaptcha')->verifCaptcha();
            if($decode['success'] === true){
                $em = $this->getDoctrine()->getManager();
                $em->persist($newCommentaire);
                $em->flush($newCommentaire);
            }
            else {
                $request->getSession()->getFlashBag()->add('Erreur', 'Vous devez cocher la case "je ne suis pas un robot" avant de valider un commentaire.');
            }
            return $this->redirectToRoute('projet_categorie_articles',[
               'idProjet' => $categories[0]->getProjet(),
                'idCate' => $categories[0]->getId(),
            ]);
        }
        return $this->render(':projet:categorie.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'commentaires' => $commentaires,
            'newCommentaire' => $newCommentaire,
            'projets' => $projets,
            'form' => $form->createView(),
        ]);

    }

    public function contactAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters

        return $form;
    }



}
