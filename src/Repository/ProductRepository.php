<?php


namespace App\Repository;

class ProductRepository extends AbstractRepository
{
    public function search($offset = 0, $limit = 5)
    {
        $queryBuilder = $this
            ->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.id', 'asc');

        return $this->paginate($queryBuilder, $offset, $limit);
    }
}