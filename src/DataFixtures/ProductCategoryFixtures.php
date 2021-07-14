<?php


namespace App\DataFixtures;

use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductCategoryFixtures extends Fixture
{
    public const PRODUCT_CATEGORY_1_REFERENCE = 'product-category-1';

    public function load(ObjectManager $manager)
    {
        $productCategory1 = new ProductCategory();
        $productCategory1->setName('Smartphone');
        $manager->persist($productCategory1);

        $manager->flush();

        $this->addReference(self::PRODUCT_CATEGORY_1_REFERENCE, $productCategory1);
    }
}