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
     * @Route("/projet/{slug}")
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
     * @Route("/projet/categorie/{slug}")
     */
    public function categorieAction()
    {

    }


}
