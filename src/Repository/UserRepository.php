<?php


namespace App\Repository;


class UserRepository extends AbstractRepository
{
    public function search($customer, $offset, $limit, $order, $firstName, $lastName)
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->join('u.customer', 'c')
            ->where('c.id = :customer')
            ->setParameter('customer', $customer->getId())
            ->orderBy('u.registeredAt', $order)
        ;

        if ($firstName) {
            $queryBuilder
                ->andWhere('u.firstName LIKE :first_name')
                ->setParameter('first_name', '%' . $firstName . '%')
            ;
        }

        if ($lastName) {
            $queryBuilder
                ->andWhere('u.lastName LIKE :last_name')
                ->setParameter('last_name', '%' . $lastName . '%')
            ;
        }

        return $this->paginate($queryBuilder, $offset, $limit);
    }
}