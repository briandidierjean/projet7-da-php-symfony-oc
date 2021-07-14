<?php


namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $queryBuilder, $offset, $limit)
    {
        if ($limit === 0) {
            throw new \LogicException('$limit must be greater than 0.');
        }

        $pager = new Pagerfanta(new QueryAdapter($queryBuilder));

        $currentPage = ceil(($offset + 1) / $limit);

        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage($limit);

        return $pager;
    }
}