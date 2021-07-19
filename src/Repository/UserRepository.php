<?php


namespace App\Repository;


use App\Entity\Customer;

/**
 * Class UserRepository
 *
 * @package App\Repository
 */
class UserRepository extends AbstractRepository
{
    /**
     * Search for users that belong to a customer.
     *
     * @param Customer $customer
     * @param int $offset
     * @param int $limit
     * @param string $order
     * @param string $firstName
     * @param string $lastName
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function search(
        Customer $customer,
        int $offset,
        int $limit,
        string $order,
        string $firstName,
        string $lastName
    )
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