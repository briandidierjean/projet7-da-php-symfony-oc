<?php


namespace App\Repository;


class UserRepository extends AbstractRepository
{
    public function search($customer, $offset = 0, $limit = 10)
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->join('u.customer', 'c')
            ->where('c.id = :customer')
            ->setParameter('customer', $customer->getId())
            ->orderBy('u.id', 'asc');

        return $this->paginate($queryBuilder, $offset, $limit);
    }
}