<?php

namespace BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Commentaires;
use BlogBundle\Entity\Categories;
use BlogBundle\Entity\Projet;

class AppController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        // replace this example code with whatever you need
        foreach ($projets as $projet){
            $contenu = $projet->getContenu();
            $html = $this->getDoctrine()->getRepository('BlogBundle:Projet')->getExtraitProjet($contenu);
            $projet->setContenu($html);
    }
        $form = $this->createForm('BlogBundle\Form\ContactType',null,array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('blog_app_index'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Refill the fields in case the form is not valid.


            // Send mail
            $this->get('app.email')->sendEmail($form->getData());
            // Everything OK, redirect to wherever you want ! :
            return $this->redirectToRoute('blog_app_index');

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
     * @Route("/projet/last")
     */
    public function lastAction(Request $request)
    {
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        $articles = $this->getDoctrine()->getRepository('BlogBundle:Articles')->findLast();
        $commentaires = $this->getDoctrine()->getRepository('BlogBundle:Commentaires')->findAll();
        $newCommentaire = new Commentaires();
        $form = $this->createForm('BlogBundle\Form\CommentairesType', $newCommentaire);
        $form->handleRequest($request);

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
            $em = $this->getDoctrine()->getManager();
            $em->persist($newCommentaire);
            $em->flush($newCommentaire);

            return $this->redirectToRoute('projet_categorie',[
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
