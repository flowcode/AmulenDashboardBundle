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
 * @Route("/admin/plugin")
 */
class PluginController extends Controller
{

    /**
     * Main Dashboard.
     *
     * @Route("/", name="admin_plugin")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $plugins = array();
        $listPluginsEvent = new ListPluginsEvent($plugins);

        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(ListPluginsEvent::NAME, $listPluginsEvent);

        return array(
            "plugins" => $listPluginsEvent->getPluginDescriptors(),
        );
    }

}
