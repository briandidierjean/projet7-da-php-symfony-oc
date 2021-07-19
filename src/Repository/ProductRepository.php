<?php


namespace App\Repository;

/**
 * Class ProductRepository
 *
 * @package App\Repository
 */
class ProductRepository extends AbstractRepository
{
    /**
     * Search for products.
     *
     * @param int $offset
     * @param int $limit
     * @param string $keyword
     * @param string $brand
     * @param string $categoryName
     * @param bool $inStock
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function search(int $offset, int $limit, string $keyword, string $brand, string $categoryName, bool $inStock)
    {
        $queryBuilder = $this
            ->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.id', 'asc')
        ;

        if ($keyword) {
            $queryBuilder
                ->where('p.name LIKE :keyword')
                ->setParameter('keyword', '%' . $keyword . '%')
            ;
        }

        if ($brand) {
            $queryBuilder
                ->andWhere('p.brand LIKE :brand')
                ->setParameter('brand', '%' . $brand . '%')
            ;
        }

        if ($categoryName) {
            $queryBuilder
                ->join('p.category', 'c')
                ->andWhere('c.name LIKE :category')
                ->setParameter('category', '%' . $categoryName . '%')
            ;
        }

        if ($inStock) $queryBuilder->andWhere('p.stock > 0');

        return $this->paginate($queryBuilder, $offset, $limit);
    }
}