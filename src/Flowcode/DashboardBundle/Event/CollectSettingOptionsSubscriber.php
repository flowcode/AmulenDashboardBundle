<?php

namespace Flowcode\DashboardBundle\Event;

use Flowcode\DashboardBundle\Entity\Setting;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\TranslatorInterface;


/**
 * CollectSettingOptionsSubscriber
 */
class CollectSettingOptionsSubscriber implements EventSubscriberInterface
{
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            CollectSettingOptionsEvent::NAME => array('handler', 1000),
        );
    }


    public function handler(CollectSettingOptionsEvent $event)
    {
        $event->addSettingOption([
            "key" => Setting::SITE_NAME,
            "label" => $this->translator->trans(Setting::SITE_NAME),
        ]);
    }
}