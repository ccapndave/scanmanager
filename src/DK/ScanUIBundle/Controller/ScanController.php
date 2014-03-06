<?php

namespace DK\ScanUIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DK\CoreBundle\Entity\Scan;
use DK\CoreBundle\Form\ScanType;

/**
 * Scan controller.
 *
 * @Route("/scan")
 */
class ScanController extends Controller {

    /**
     * Lists all Scan entities.
     *
     * @Route("/", name="scan")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DKCoreBundle:Scan')->findAll();

        foreach ($entities as $entity)
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();

        return array(
            'entities' => $entities,
            'deleteForms' => $deleteForms
        );
    }

    /**
     * Creates a new Scan entity.
     *
     * @Route("/", name="scan_create")
     * @Method("POST")
     * @Template("DKScanUIBundle:Scan:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Scan();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('scan_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Scan entity.
     *
     * @param Scan $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Scan $entity) {
        $form = $this->createForm(new ScanType(), $entity, array(
            'action' => $this->generateUrl('scan_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Scan entity.
     *
     * @Route("/new", name="scan_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Scan();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Scan entity.
     *
     * @Route("/{id}", name="scan_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DKCoreBundle:Scan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Scan entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Scan entity.
     *
     * @Route("/{id}/edit", name="scan_edit", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DKCoreBundle:Scan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Scan entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Scan entity.
     *
     * @param Scan $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Scan $entity) {
        $form = $this->createForm(new ScanType(), $entity, array(
            'action' => $this->generateUrl('scan_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Scan entity.
     *
     * @Route("/{id}", name="scan_update")
     * @Method("PUT")
     * @Template("DKScanUIBundle:Scan:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DKCoreBundle:Scan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Scan entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('scan_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Scan entity.
     *
     * @Route("/{id}", name="scan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DKCoreBundle:Scan')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Scan entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('scan'));
    }

    /**
     * Creates a form to delete a Scan entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scan_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'), array('class' => array('btn btn-default')))
            ->getForm();
    }
}
