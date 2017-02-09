<?php

namespace AppBundle\Controller;

use Elastica\Query;
use Elastica\QueryBuilder\DSL\Aggregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     * @Route(path="/search")
     */
    public function sandboxAction()
    {
        //$manager = $this->get('fos_elastica.index_manager');
        //$manager->getIndex('app')->getType('artist');

        $finder = $this->get('fos_elastica.finder.app.artist');

        $boolQuery = new Query\BoolQuery();
        $boolQuery->addMust(new Query\Range('creationYear', ['from' => 1960, 'to' => 1980]))
              ->addMust(new Query\Range('albumCount', ['gte' => 1]));
              //->addMustNot(new Query\Term(['genres.raw' => 'Crossover']))
              //->addShould(new Query\Match('name', 'Floyd'))
              //->addShould(new Query\Match('biography', 'peut'));

        $query = new \Elastica\Query($boolQuery);
        $query->setHighlight(['fields' => ['biography' => (object)[]]]);
        $query->setSort(['name.raw' => 'asc']);


//        $query = [
//          'query' => [
//              'bool' => [
//                  'must' => [
//                      ['range' => ['creationYear' => ['from' => 1960, 'to' => 1980]]],
//                      ['range' => ['albumCount' => ['gte' => 1]]],
//                  ]
//              ],
//          ],
//        ];

        $artists = $finder->findHybrid($query);
        dump($artists);

        return $this->render('search/sandbox.html.twig', ['artists' => $artists]);
    }
}
