<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 * @Route("admin")
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
     * @Route("/projet/{idProjet}/categorie/{idCate}")
     */
    public function categorieAction($idCate,$idProjet,Request $request)
    {

        $articles = $this->getDoctrine()->getRepository('BlogBundle:Articles')->findByCategorie($idCate);
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($idProjet);

        return $this->render(':admin/articles:index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);

    }



    /**
     * Creates a new article entity.
     *
     * @Route("/articles/new", name="admin_articles_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('BlogBundle\Form\ArticlesType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //utilisation du service file_uploader
            $file = $article->getImageURL();
            $fileName = $this->get('app.file_uploader')->upload($file);
            $article->setImageURL($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush($article);

            return $this->redirectToRoute('admin_articles_show', array('id' => $article->getId()));
        }

        return $this->render('articles/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
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

            return $this->redirectToRoute('admin_articles_edit', array('id' => $article->getId()));
        }

        return $this->render('admin/articles/edit.html.twig', array(
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
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush($article);
        }

        return $this->redirectToRoute('admin_articles_index');
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
