<?php

namespace Flowcode\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Flowcode\DashboardBundle\Entity\Job;
use Flowcode\DashboardBundle\Form\Type\JobType;
use Doctrine\ORM\QueryBuilder;

/**
 * Job controller.
 *
 * @Route("/admin/amulen/job")
 */
class JobController extends Controller
{
    /**
     * Lists all Job entities.
     *
     * @Route("/", name="admin_amulen_job")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $request->get("page", 1);
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT j FROM FlowcodeDashboardBundle:Job j ORDER BY j.updated DESC";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, $this->get('request')->query->get('page', $page), 50);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * Finds and displays a Job entity.
     *
     * @Route("/{id}/show", name="admin_amulen_job_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Job $job)
    {
        $editForm = $this->createForm(new JobType(), $job, array(
            'action' => $this->generateUrl('admin_amulen_job_update', array('id' => $job->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($job->getId(), 'admin_amulen_job_delete');

        return array(

            'job' => $job, 'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        );
    }

    /**
     * Displays a form to create a new Job entity.
     *
     * @Route("/new", name="admin_amulen_job_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $job = new Job();
        $form = $this->createForm(new JobType(), $job);

        return array(
            'job' => $job,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Job entity.
     *
     * @Route("/create", name="admin_amulen_job_create")
     * @Method("POST")
     * @Template("FlowcodeDashboardBundle:Job:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $job = new Job();
        $form = $this->createForm(new JobType(), $job);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_amulen_job_show', array('id' => $job->getId())));
        }

        return array(
            'job' => $job,
            'form' => $form->createView(),
        );
    }

    /**
     * Edits an existing Job entity.
     *
     * @Route("/{id}/update", name="admin_amulen_job_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("FlowcodeDashboardBundle:Job:edit.html.twig")
     */
    public function updateAction(Job $job, Request $request)
    {
        $editForm = $this->createForm(new JobType(), $job, array(
            'action' => $this->generateUrl('admin_amulen_job_update', array('id' => $job->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_amulen_job_show', array('id' => $job->getId())));
        }
        $deleteForm = $this->createDeleteForm($job->getId(), 'admin_amulen_job_delete');

        return array(
            'job' => $job,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}/delete", name="admin_amulen_job_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Job $job, Request $request)
    {
        $form = $this->createDeleteForm($job->getId(), 'admin_amulen_job_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_amulen_job'));
    }

    /**
     * Create Delete form
     *
     * @param integer $id
     * @param string $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
    }

}
