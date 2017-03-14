<?php

namespace Flowcode\DashboardBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Created by PhpStorm.
 * User: juanma
 * Date: 5/28/16
 * Time: 12:11 PM
 */
class CollectSettingOptionsEvent extends Event
{
    const NAME = 'amulen.event.collect_setting_options';

    protected $settingOptions = [];


    /**
     * @param $settingOption
     */
    public function addSettingOption($settingOption)
    {
        array_push($this->settingOptions, $settingOption);
    }

    /**
     * @return mixed
     */
    public function getSettingOptions()
    {
        return $this->settingOptions;
    }

    /**
     * @param mixed $settingOptions
     */
    public function setSettingOptions($settingOptions)
    {
        $this->settingOptions = $settingOptions;
    }


}