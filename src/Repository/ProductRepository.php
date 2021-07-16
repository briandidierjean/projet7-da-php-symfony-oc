<?php


namespace App\Repository;

class ProductRepository extends AbstractRepository
{
    public function search(
        $offset = 0,
        $limit = 5,
        $keyword = null,
        $brand = null,
        $category = null,
        $in_stock = 'false'
    )
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
                ->setParameter('brand', $brand)
            ;
        }

        if ($category) {
            $queryBuilder
                ->join('p.category', 'c')
                ->andWhere('c.name LIKE :category')
                ->setParameter('category', $category)
            ;
        }

        if ($in_stock === 'true') $queryBuilder->andWhere('p.stock > 0');

        return $this->paginate($queryBuilder, $offset, $limit);
    }
}