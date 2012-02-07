<?php

namespace W4H\Bundle\EventTaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use W4H\Bundle\EventTaskBundle\Entity\ActivityType;
use W4H\Bundle\EventTaskBundle\Form\ActivityTypeType;

/**
 * ActivityType controller.
 *
 * @Route("/activity-type")
 */
class ActivityTypeController extends Controller
{
    /**
     * Lists all ActivityType entities.
     *
     * @Route("/", name="activitytype")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('W4HEventTaskBundle:ActivityType')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ActivityType entity.
     *
     * @Route("/{id}/show", name="activitytype_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('W4HEventTaskBundle:ActivityType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActivityType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ActivityType entity.
     *
     * @Route("/new", name="activitytype_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ActivityType();
        $form   = $this->createForm(new ActivityTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ActivityType entity.
     *
     * @Route("/create", name="activitytype_create")
     * @Method("post")
     * @Template("W4HEventTaskBundle:ActivityType:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ActivityType();
        $request = $this->getRequest();
        $form    = $this->createForm(new ActivityTypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('activitytype_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ActivityType entity.
     *
     * @Route("/{id}/edit", name="activitytype_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('W4HEventTaskBundle:ActivityType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActivityType entity.');
        }

        $editForm = $this->createForm(new ActivityTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ActivityType entity.
     *
     * @Route("/{id}/update", name="activitytype_update")
     * @Method("post")
     * @Template("W4HEventTaskBundle:ActivityType:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('W4HEventTaskBundle:ActivityType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActivityType entity.');
        }

        $editForm   = $this->createForm(new ActivityTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('activitytype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ActivityType entity.
     *
     * @Route("/{id}/delete", name="activitytype_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('W4HEventTaskBundle:ActivityType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ActivityType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('activitytype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
