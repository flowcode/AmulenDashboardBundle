<?php

namespace Flowcode\DashboardBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Created by PhpStorm.
 * User: juanma
 * Date: 5/28/16
 * Time: 12:11 PM
 */
class ListPluginsEvent extends Event
{
    const NAME = 'amulen.event.plugin_list';

    protected $pluginDescriptors;

    /**
     * ListPluginsEvent constructor.
     * @param $pluginDescriptors
     */
    public function __construct($pluginDescriptors)
    {
        $this->pluginDescriptors = $pluginDescriptors;
    }


    /**
     * @return mixed
     */
    public function getPluginDescriptors()
    {
        return $this->pluginDescriptors;
    }

    /**
     * @param mixed $pluginDescriptors
     */
    public function setPluginDescriptors($pluginDescriptors)
    {
        $this->pluginDescriptors = $pluginDescriptors;
    }


}