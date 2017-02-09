<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 08/02/2017
 * Time: 11:49
 */

namespace AppBundle\EventListener;

use AppBundle\Event\ArtistEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class ArtistViewCountListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onShow(ArtistEvent $event)
    {
        $session = $this->requestStack->getMasterRequest()->getSession();
        $artistViewCountKey = sprintf('artistViewCount_%s', $event->getArtist()->getId());
        $artistViewCount = $session->get($artistViewCountKey, 0);
        $artistViewCount++;
        $session->set($artistViewCountKey, $artistViewCount);
    }
}
