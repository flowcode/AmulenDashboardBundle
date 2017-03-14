<?php

namespace Flowcode\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Flowcode\DashboardBundle\Entity\Setting;
use Flowcode\DashboardBundle\Form\Type\SettingType;
use Doctrine\ORM\QueryBuilder;

/**
 * Setting controller.
 *
 * @Route("/admin/amulen/setting")
 */
class SettingController extends Controller
{
    /**
     * Lists all Setting entities.
     *
     * @Route("/", name="admin_amulen_setting")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FlowcodeDashboardBundle:Setting')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Setting entity.
     *
     * @Route("/{id}/show", name="admin_amulen_setting_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Setting $setting)
    {
        $editForm = $this->createForm($this->get('amulen.dashboard.form.setting'), $setting, array(
            'action' => $this->generateUrl('admin_amulen_setting_update', array('id' => $setting->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($setting->getId(), 'admin_amulen_setting_delete');

        return array(

            'setting' => $setting, 'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        );
    }

    /**
     * Displays a form to create a new Setting entity.
     *
     * @Route("/new", name="admin_amulen_setting_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $setting = new Setting();
        $form = $this->createForm($this->get('amulen.dashboard.form.setting'), $setting);

        return array(
            'setting' => $setting,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Setting entity.
     *
     * @Route("/create", name="admin_amulen_setting_create")
     * @Method("POST")
     * @Template("FlowcodeDashboardBundle:Setting:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $setting = new Setting();
        $form = $this->createForm($this->get('amulen.dashboard.form.setting'), $setting);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_amulen_setting_show', array('id' => $setting->getId())));
        }

        return array(
            'setting' => $setting,
            'form' => $form->createView(),
        );
    }

    /**
     * Edits an existing Setting entity.
     *
     * @Route("/{id}/update", name="admin_amulen_setting_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("FlowcodeDashboardBundle:Setting:edit.html.twig")
     */
    public function updateAction(Setting $setting, Request $request)
    {
        $editForm = $this->createForm($this->get('amulen.dashboard.form.setting'), $setting, array(
            'action' => $this->generateUrl('admin_amulen_setting_update', array('id' => $setting->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_amulen_setting_show', array('id' => $setting->getId())));
        }
        $deleteForm = $this->createDeleteForm($setting->getId(), 'admin_amulen_setting_delete');

        return array(
            'setting' => $setting,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Setting entity.
     *
     * @Route("/{id}/delete", name="admin_amulen_setting_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Setting $setting, Request $request)
    {
        $form = $this->createDeleteForm($setting->getId(), 'admin_amulen_setting_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($setting);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_amulen_setting'));
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
