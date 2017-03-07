<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('index.html.twig', [
            'projets' => $projets,
        ]);
    }

    /**
     * @Route("/projet/{slug}", requirements={"slug": "\d+"})
     */
    public function projetAction($slug,Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($slug);
        $projet = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findOneById($slug);

        return $this->render('projet.html.twig', [
            'categories' => $categories,
            'projet' => $projet,
        ]);

    }


    /**
     * @Route("/projet/{idProjet}/categorie/{idCate}")
     */
    public function categorieAction($idCate,$idProjet,Request $request)
    {

        $articles = $this->getDoctrine()->getRepository('BlogBundle:Articles')->findByCategorie($idCate);
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($idProjet);

        return $this->render(':projet:categorie.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);

    }


}
