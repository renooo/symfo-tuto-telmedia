<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelpController extends Controller
{
    public function indexAction()
    {
        return new Response('Pas de panique, Chuck Norris arrive !');
    }

    /**
     * @param $hero
     * @return Response
     */
    public function heroAction($hero)
    {
        return new Response(sprintf("Attention, %s est en route !", $hero));
    }

    /**
     * @Route(path="/contact-tel", name="app_help_phone_tel")
     * @Route(path="/contact-phone", name="app_help_phone_phone")
     *
     * @return Response
     */
    public function phoneAction()
    {
        return new Response('Ghostbusters !');
    }

    /**
     * @Route(path="/debug-request")
     */
    public function debugRequestAction(Request $request)
    {
        dump($request);
        return new Response('Debug time !');
    }

    /**
     * @Route(path="/debug-response")
     * @return Response
     */
    public function debugResponseAction()
    {
        $response = new Response('ça marche');
        $response->setContent('ça marche encore !')
                 ->setStatusCode(Response::HTTP_OK);

        $response = new JsonResponse([
            ['name' => 'Pink Floyd', 'creationYear' => 1965],
            ['name' => 'Led Zeppelin', 'creationYear' => 1967],
        ]);

        $response = new RedirectResponse($this->generateUrl('help_hero', ['hero' => 'mauviette']));

        return $response;
    }
}
