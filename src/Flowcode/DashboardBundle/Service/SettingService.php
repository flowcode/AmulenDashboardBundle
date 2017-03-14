<?php

namespace Flowcode\DashboardBundle\Service;

use Doctrine\ORM\EntityRepository;
use Flowcode\DashboardBundle\Entity\Setting;
use Flowcode\DashboardBundle\Event\CollectSettingOptionsEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * User: juanma
 * Date: 5/28/16
 * Time: 6:03 PM
 */
class SettingService
{

    private $settingRepository;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * SettingService constructor.
     * @param $settingRepository
     */
    public function __construct(EntityRepository $settingRepository, $dispatcher)
    {
        $this->settingRepository = $settingRepository;
        $this->dispatcher = $dispatcher;
    }

    public function getValue($settingName)
    {
        $setting = $this->settingRepository->findOneBy(array(
            'name' => $settingName,
        ));
        if ($setting) {
            return $setting->getValue();
        }
        return null;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $settingOptions = array();

        $collectSettingOptionsEvent = new CollectSettingOptionsEvent();
        $collectSettingOptionsEvent->setSettingOptions($settingOptions);

        $this->dispatcher->dispatch(CollectSettingOptionsEvent::NAME, $collectSettingOptionsEvent);

        return $collectSettingOptionsEvent->getSettingOptions();
    }

    /**
     * Get setting value.
     *
     * @param $key
     * @return null|string
     */
    public function get($key)
    {
        /**
         * @var Setting $setting
         */
        $setting = $this->settingRepository->findOneBy(array(
            'name' => $key,
        ));
        if ($setting) {
            return $setting->getValue();
        }
        return null;
    }


    public function currentVersion()
    {
        return "0.4.2";
    }

}