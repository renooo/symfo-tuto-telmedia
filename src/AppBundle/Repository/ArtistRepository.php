<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 07/02/2017
 * Time: 11:42
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Artist;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ArtistRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy([], ['name' => 'ASC']);
    }

    public function search($criteria = [])
    {
        $qb = $this->createQueryBuilder('a');

        if (array_key_exists('name', $criteria) && !empty($criteria['name'])) {
            $qb->andWhere('a.name LIKE :name')
                ->setParameter('name', '%'.$criteria['name'].'%')
                ->addOrderBy('name', 'ASC');
        }

        if (array_key_exists('decade', $criteria) && !empty($criteria['decade'])) {
            $this->buildDecadeQuery($qb, $criteria['decade']);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param int $decade
     * @return Artist[]
     */
    public function findByDecade($decade)
    {
        $qb = $this->createQueryBuilder('a');
        $this->buildDecadeQuery($qb, $decade);

        return $qb->getQuery()->execute();
    }

    private function buildDecadeQuery(QueryBuilder $qb, $decade)
    {
        $qb->andWhere('a.creationYear >= :min')
            ->andWhere('a.creationYear < :max')
            ->setParameter('min', $decade)
            ->setParameter('max', $decade + 10)
            ->orderBy('a.creationYear', 'ASC');

        return $qb;
    }
}
