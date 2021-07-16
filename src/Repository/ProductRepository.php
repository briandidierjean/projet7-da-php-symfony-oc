<?php


namespace App\Repository;

class ProductRepository extends AbstractRepository
{
    public function search($offset, $limit, $keyword, $brand, $categoryName, $in_stock)
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

        if ($in_stock === 'true') $queryBuilder->andWhere('p.stock > 0');

        return $this->paginate($queryBuilder, $offset, $limit);
    }
}