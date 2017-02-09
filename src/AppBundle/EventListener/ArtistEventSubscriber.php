<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 08/02/2017
 * Time: 15:21
 */

namespace AppBundle\EventListener;

use AppBundle\Event\ArtistEvent;
use AppBundle\Events\ArtistEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArtistEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ArtistEvents::SHOW => 'onShow',
            ArtistEvents::CREATE => 'onCreate',
            ArtistEvents::EDIT => 'onEdit',
        ];
    }

    public function onShow(ArtistEvent $event)
    {
        dump(__METHOD__);
        dump($event->getArtist()->getName());
    }

    public function onCreate(ArtistEvent $event)
    {
        dump(__METHOD__);
        dump($event->getArtist()->getName());
    }

    public function onEdit(ArtistEvent $event)
    {
        dump(__METHOD__);
        dump($event->getArtist()->getName());
    }
}
