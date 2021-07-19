<?php


namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class AbstractRepository
 *
 * @package App\Repository
 */
abstract class AbstractRepository extends EntityRepository
{
    /**
     * Paginate data.
     *
     * @param QueryBuilder $queryBuilder
     * @param int $offset
     * @param int $limit
     *
     * @return Pagerfanta
     */
    protected function paginate(QueryBuilder $queryBuilder, int $offset, int $limit)
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