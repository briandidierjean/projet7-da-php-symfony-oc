<?php


namespace App\DataFixtures;

use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ProductCategoryFixtures
 *
 * @package App\DataFixtures
 */
class ProductCategoryFixtures extends Fixture
{
    /**
     * @var string
     */
    public const SMARTPHONE_CATEGORY_REFERENCE = 'smartphone-category';

    /**
     * Load product categories data.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $smartphoneCategory = new ProductCategory();
        $smartphoneCategory->setName('Smartphone');
        $manager->persist($smartphoneCategory);

        $manager->flush();

        $this->addReference(self::SMARTPHONE_CATEGORY_REFERENCE, $smartphoneCategory);
    }
}