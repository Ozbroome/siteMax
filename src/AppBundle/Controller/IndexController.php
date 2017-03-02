<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Route("/", name="")
     */
    public function indexAction(Request $request)
    {
        $bonjour = "Bonjour";
        // replace this example code with whatever you need
        return $this->render('index.html.twig', [
            'bonjour' => $bonjour,
        ]);
    }
}
