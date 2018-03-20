<?php

namespace Flowcode\DashboardBundle\Service;

use Amulen\SettingsBundle\Model\SettingRepository;
use Doctrine\ORM\EntityRepository;
use Flowcode\DashboardBundle\Entity\Setting;
use Flowcode\DashboardBundle\Event\CollectSettingOptionsEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * User: juanma
 * Date: 5/28/16
 * Time: 6:03 PM
 */
class SettingService implements SettingRepository
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
    public function getOneByKey($key)
    {
        /**
         * @var Setting $setting
         */
        $setting = $this->settingRepository->findOneBy(array(
            'name' => $key,
        ));

        return $setting;
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

    /**
     * Get setting value.
     *
     * @param $key
     * @return null|string
     */
    public function getByKey($key)
    {
        /**
         * @var Setting $setting
         */
        $settings = $this->settingRepository->findBy(array(
            'name' => $key,
        ));
        $return = array();
        if ($settings) {
            foreach ($settings as $setting) {
                $return[] = strtolower($setting->getValue());
            }
        }
        return $return;
    }


    public function currentVersion()
    {
        return "0.4.2";
    }

}