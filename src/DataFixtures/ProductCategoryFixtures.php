<?php


namespace App\DataFixtures;

use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductCategoryFixtures extends Fixture
{
    public const SMARTPHONE_CATEGORY_REFERENCE = 'smartphone-category';

    public function load(ObjectManager $manager)
    {
        $smartphoneCategory = new ProductCategory();
        $smartphoneCategory->setName('Smartphone');
        $manager->persist($smartphoneCategory);

        $manager->flush();

        $this->addReference(self::SMARTPHONE_CATEGORY_REFERENCE, $smartphoneCategory);
    }
}