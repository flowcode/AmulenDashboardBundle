<?php

namespace Flowcode\DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Dashboard Class.
 * 
 * @Route("/admin")
 */
class DefaultController extends Controller {

    /**
     * Main Dashboard.
     *
     * @Route("/", name="admin_dashboard")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AmulenShopBundle:Product')->findAll();
        $countries = $em->getRepository('AppBundle:Country')->findAll();
        $industries = $em->getRepository('AppBundle:Industry')->findAll();

        $qtyProducts = count($products);
        $qtyCountries = count($countries);
        $qtyIndustries = count($industries);

        $today = date("d/m/Y H:m");

        return $this->render('FlowcodeDashboardBundle:Default:index.html.twig', array(
            "datime" => $today,
            "qtyProducts" => $qtyProducts,
            "qtyCountries" => $qtyCountries,
            "qtyIndustries" => $qtyIndustries,
        ));
    }

}
