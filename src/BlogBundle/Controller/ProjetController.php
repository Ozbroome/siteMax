<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use BlogBundle\FileUploader;

/**
 * Projet controller.
 *
 * @Route("/admin/projet")
 */
class ProjetController extends Controller
{
    /**
     * Lists all projet entities.
     *
     * @Route("/", name="projet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projets = $em->getRepository('BlogBundle:Projet')->findAll();

        return $this->render(':admin/projet:index.html.twig', array(
            'projets' => $projets,
        ));
    }

    /**
     * Creates a new projet entity.
     *
     * @Route("/new", name="projet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        $projet = new Projet();

        //test existence fichier dans le répertoire et dans la base de donnée.
        $directory = $this->getParameter('img_directory');
        $this->get('app.file_uploader')->testFile($directory,$projet);


        $form = $this->createForm('BlogBundle\Form\ProjetType', $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //utilisation du service file_uploader
            $file = $projet->getImageURL();
            $fileName = $this->get('app.file_uploader')->upload($file);
            $projet->setImageURL($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush($projet);

            return $this->redirectToRoute('projet_index', array('id' => $projet->getId()));
        }

        return $this->render(':admin/projet:new.html.twig', array(
            'projet' => $projet,
            'form' => $form->createView(),
            'projets' => $projets,

        ));
    }

    /**
     * Finds and displays a projet entity.
     *
     * @Route("/{id}", name="projet_show")
     * @Method("GET")
     */
    public function showAction(Projet $projet)
    {
        $deleteForm = $this->createDeleteForm($projet);

        return $this->render(':admin/projet:show.html.twig', array(
            'projet' => $projet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing projet entity.
     *
     * @Route("/{id}/edit", name="projet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id,Request $request, Projet $projet)
    {
        $projets = $this->getDoctrine()->getRepository('BlogBundle:Projet')->findAll();
        //test existence fichier dans le répertoire et dans la base de donnée.
        $directory = $this->getParameter('img_directory');
        $this->get('app.file_uploader')->testFile($directory,$projet);
        $file = $projet->getImageURL();
        //Création form
        $deleteForm = $this->createDeleteForm($projet);
        $editForm = $this->createForm('BlogBundle\Form\ProjetType', $projet);
        $editForm->handleRequest($request);
        $categories = $this->getDoctrine()->getRepository('BlogBundle:Categories')->findByProjet($id);
        $em = $this->getDoctrine()->getManager();


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if (!null == $projet->getImageURL()){
                $file = $projet->getImageURL();
            }
            if($file !== '') {
                $fileName = $this->get('app.file_uploader')->upload($file);
                $projet->setImageURL($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_edit', array('id' => $projet->getId()));
        }

        return $this->render(':admin/projet:edit.html.twig', array(
            'projets' => $projets,
            'projet' => $projet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'categories' => $categories,
        ));
    }

    /**
     * Deletes a projet entity.
     *
     * @Route("/{id}", name="projet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Projet $projet)
    {
        $form = $this->createDeleteForm($projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($projet);
            $em->flush($projet);
        }

        return $this->redirectToRoute('projet_index');
    }

    /**
     * Creates a form to delete a projet entity.
     *
     * @param Projet $projet The projet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Projet $projet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('projet_delete', array('id' => $projet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
