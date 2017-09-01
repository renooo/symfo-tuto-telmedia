<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 08/02/2017
 * Time: 15:21
 */

namespace AppBundle\EventListener;

use AppBundle\Client\BandsInTownClient;
use AppBundle\Event\ArtistEvent;
use AppBundle\Events\ArtistEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArtistEventSubscriber implements EventSubscriberInterface
{
    private $bandsInTownClient;

    public function __construct(BandsInTownClient $bandsInTownClient)
    {
        $this->bandsInTownClient = $bandsInTownClient;
    }

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
        $name = $this->bandsInTownClient->normalizeArtistName($event->getArtist()->getName());
    }

    public function onEdit(ArtistEvent $event)
    {
        dump(__METHOD__);
        dump($event->getArtist()->getName());
    }
}
