<?php

namespace Flowcode\DashboardBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Created by PhpStorm.
 * User: juanma
 * Date: 5/28/16
 * Time: 12:11 PM
 */
class ShowMenuEvent extends Event
{
    const NAME = 'amulen.event.admin_menu_show';

    protected $menuOptions;

    public function __construct($menuOptions)
    {
        $this->menuOptions = $menuOptions;
    }

    /**
     * @return mixed
     */
    public function getMenuOptions()
    {
        return $this->menuOptions;
    }

    /**
     * @param mixed $menuOptions
     */
    public function setMenuOptions($menuOptions)
    {
        $this->menuOptions = $menuOptions;
    }


}