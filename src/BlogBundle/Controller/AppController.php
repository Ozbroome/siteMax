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
        return $this->render('index.html.twig', [
            'projets' => $projets,
            'html' => $html,
        ]);
    }

    /**
     * @Route("/projet/{slug}", requirements={"slug": "\d+"})
     */
    public function projetAction($slug,Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($slug);
        $projet = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findOneById($slug);
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
     * @Route("/projet/{idProjet}/categorie/{idCate}", name="projet_categorie")
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


}
