<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 * @Route("/admin")
 */
class ArticlesController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/articles/", name="admin_articles_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('BlogBundle:Articles')->findAll();

        return $this->render('articles/index.html.twig', array(
            'articles' => $articles,
        ));
    }


    /**
     * @Route("/projet/{idProjet}/categorie/{idCate}", name="admin_projet_categorie")
     */
    public function categorieAction($idCate,$idProjet,Request $request)
    {
        $commentaires = $this->getDoctrine()->getRepository('BlogBundle:Commentaires')->findAll();
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        $articles = $this->getDoctrine()->getRepository('BlogBundle:Articles')->findByCategorie($idCate);
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($idProjet);

        return $this->render(':admin/articles:index.html.twig', [
            'projets' => $projets,
            'articles' => $articles,
            'categories' => $categories,
            'commentaires' => $commentaires,
            'idCate' => $idCate,
        ]);

    }



    /**
     * Creates a new article entity.
     *
     * @Route("/articles/new/{idCate}", name="admin_articles_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$idCate)
    {
        $categorie = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findOneById($idCate);
        $idProjet = $categorie->getProjet();
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        $article = new Articles();
        $article->setCategorie($categorie);
        $form = $this->createForm('BlogBundle\Form\ArticlesType', $article);
        $form->handleRequest($request);
        $directory = $this->getParameter('img_directory');
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $article->getImageURL();
            if(null !== $file) {
                $fileName = $this->get('app.file_uploader')->upload($file);
                $article->setImageURL($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush($article);
            return $this->redirectToRoute('admin_projet_categorie', array('idProjet' => $idProjet,'idCate' => $idCate));
        }
        return $this->render('admin/articles/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
            'projets' => $projets,
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/articles/{id}", name="admin_articles_show")
     * @Method("GET")
     */
    public function showAction(Articles $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('articles/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="admin_articles_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Articles $article)
    {
        $idCate = $article->getCategorie();
        $idProjet = $idCate->getProjet();
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        //test existence fichier dans le répertoire et dans la base de donnée.
        $directory = $this->getParameter('img_directory');
        $this->get('app.file_uploader')->testFile($directory,$article);
        $file = $article->getImageURL();
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('BlogBundle\Form\ArticlesType', $article);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if (!null == $article->getImageURL()){
                $file = $article->getImageURL();
            }
            //utilisation du service file_uploader
            if($file !== ''){
                $fileName = $this->get('app.file_uploader')->upload($file);
                $article->setImageURL($fileName);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_projet_categorie', array('idProjet' => $idProjet,'idCate' => $idCate));
        }
        return $this->render('admin/articles/edit.html.twig', array(
            'projets' => $projets,
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/articles/{id}", name="admin_articles_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Articles $article)
    {
        $idCate = $article->getCategorie();
        $idProjet = $idCate->getProjet();
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush($article);
        }

        return $this->redirectToRoute('admin_projet_categorie', array('idProjet' => $idProjet,'idCate' => $idCate));

    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Articles $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Articles $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_articles_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
