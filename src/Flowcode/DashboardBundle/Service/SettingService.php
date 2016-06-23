<?php

namespace Flowcode\DashboardBundle\Service;
use Doctrine\ORM\EntityRepository;

/**
 * User: juanma
 * Date: 5/28/16
 * Time: 6:03 PM
 */
class SettingService
{

    private $settingRepository;

    /**
     * SettingService constructor.
     * @param $settingRepository
     */
    public function __construct(EntityRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
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


    public function currentVersion()
    {
        return "0.4.1";
    }

}