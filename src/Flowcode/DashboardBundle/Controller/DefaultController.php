<?php

namespace Flowcode\DashboardBundle\Controller;

use Flowcode\DashboardBundle\Event\ListPluginsEvent;
use Flowcode\DashboardBundle\Event\ShowMenuEvent;
use Flowcode\DashboardBundle\Event\ShowMenuSubscriber;
use Flowcode\DashboardBundle\Listener\ShowMenuListener;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Dashboard Class.
 *
 * @Route("/admin")
 */
class DefaultController extends Controller
{

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
        $mostViewed = $em->getRepository("AmulenPageBundle:Page")->getMostViewed(5);
        $viewCount = $em->getRepository("AmulenPageBundle:Page")->getTotalViewedCount();

        $today = date("d/m/Y H:m");

        return $this->render('FlowcodeDashboardBundle:Default:index.html.twig', array(
            "datime" => $today,
            "mostViewed" => $mostViewed,
            "viewCount" => $viewCount,
        ));
    }

    public function menuAction()
    {

        $menuOptions = array();
        $showMenuEvent = new ShowMenuEvent($menuOptions);

        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(ShowMenuEvent::NAME, $showMenuEvent);

        return $this->render('FlowcodeDashboardBundle:Default:menu.html.twig', array(
            "menuOptions" => $showMenuEvent->getMenuOptions(),
        ));

    }

    public function pluginsAction()
    {

        $plugins = array();
        $listPluginsEvent = new ListPluginsEvent($plugins);

        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(ListPluginsEvent::NAME, $listPluginsEvent);

        return $this->render('FlowcodeDashboardBundle:Default:plugins.html.twig', array(
            "plugins" => $listPluginsEvent->getPluginDescriptors(),
        ));

    }

}
