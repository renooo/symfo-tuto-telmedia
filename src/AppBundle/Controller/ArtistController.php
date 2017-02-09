<?php

namespace AppBundle\Controller;

use AppBundle\Client\BandsInTownClient;
use AppBundle\Entity\Artist;
use AppBundle\Event\ArtistEvent;
use AppBundle\Events\ArtistEvents;
use AppBundle\Form\ArtistFormType;
use AppBundle\Form\ArtistSearchFormType;
use AppBundle\Repository\ArtistRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;

class ArtistController extends Controller
{
    private function getMagicNumbers()
    {
        $cache = $this->get('cache.app');
        $cachedNumbers = $cache->getItem('magicNumbers');

        if (!$cachedNumbers->isHit()) {
            sleep(2);

            $numbers = [
                rand(1, 42),
                rand(1, 42),
                rand(1, 42),
                rand(1, 42),
                rand(1, 42),
            ];

            $cachedNumbers->set($numbers);
            $cache->save($cachedNumbers);
        }


        return $cachedNumbers->get();
    }

    /**
     * @Route(path="/artists")
     * @Route(path="/artists/{year}", requirements={"year": "\d{4,4}"}, name="app_artist_index_year")
     * @Route(path="/artists/{decade}", requirements={"decade": "\d{3,3}0s"}, name="app_artist_index_decade")
     * @return Response
     */
    public function indexAction($year = null, $decade = null)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        /** @var ArtistRepository $repo */
        $repo = $em->getRepository('AppBundle:Artist');

        if (null !== $year) {
            $artists = $repo->findByCreationYear((int) $year);
        }elseif (null !== $decade) {
            $decade = (int) rtrim($decade, 's');
            $artists = $repo->findByDecade($decade);
        }else{
            $artists = $repo->findAll();
        }

        $data = [
            'artists' => $artists,
        ];

        return $this->render('artist/index.html.twig', $data);
    }

    /**
     * @Route(
     *     path="/artist/{id}",
     *     requirements={"id": "\d+"}
     * )
     * @return Response
     */
    public function showAction(Artist $artist)
    {
        $bitClient = $this->get('bandsintown.client');
        $tourDates = $bitClient->getTourDates($artist);

        $data = [
          'artist' => $artist,
          'tourDates' => $tourDates,
        ];

        $this->get('event_dispatcher')->dispatch(ArtistEvents::SHOW, new ArtistEvent($artist));

        return $this->render('artist/show.html.twig', $data);
    }

    /**
     * @Route(path="/artists/search")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(ArtistSearchFormType::class);
        $artists = [];

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $artists = $this->getDoctrine()
                            ->getRepository('AppBundle:Artist')
                            ->search($form->getData());
        }

        return $this->render('artist/search.html.twig', [
            'searchForm' => $form->createView(),
            'artists' => $artists,
        ]);
    }

    /**
     * @Route(path="/artist/create")
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistFormType::class, $artist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();
            
            $this->get('event_dispatcher')->dispatch(ArtistEvents::CREATE, new ArtistEvent($artist));

            return $this->redirectToRoute('app_artist_show', ['id' => $artist->getId()]);
        }

        return $this->render('artist/create.html.twig', [
           'artistForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/artist/{id}/edit")
     * @param Request $request
     */
    public function editAction(Request $request, Artist $artist)
    {
        $this->denyAccessUnlessGranted('edit', $artist, 'Vous ne passerez pas !');

        $form = $this->createForm(ArtistFormType::class, $artist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();

            $this->get('event_dispatcher')->dispatch(ArtistEvents::EDIT, new ArtistEvent($artist));

            return $this->redirectToRoute('app_artist_show', ['id' => $artist->getId()]);
        }

        return $this->render('artist/edit.html.twig', [
            'artistForm' => $form->createView(),
            'artist' => $artist,
        ]);
    }
}
