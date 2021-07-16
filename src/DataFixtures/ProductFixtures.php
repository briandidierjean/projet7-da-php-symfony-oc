<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
        $this->faker->seed(5486);
    }

    public function generateSmartphone($name, $brand, $price)
    {
        $product = new Product();
        $product->setReference(strtoupper(substr($this->faker->unique()->uuid(), 0, 20)));
        $product->setName($name);
        $product->setBrand($brand);
        $product->setDescription($this->faker->paragraph(5));
        $product->setCategory($this->getReference(ProductCategoryFixtures::SMARTPHONE_CATEGORY_REFERENCE));
        $product->setUnitPriceOffTax($price);
        $product->setVATRate100(20);
        $product->setStock($this->faker->randomDigit);

        return $product;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist($this->generateSmartphone(
            'iPhone 12 Mauve 64 Go',
            'Apple',
            799)
        );

        $manager->persist($this->generateSmartphone(
            'iPhone SE Noir 64 Go',
            'Apple',
            500)
        );

        $manager->persist($this->generateSmartphone(
            'iPhone 12 Noir 128 Go',
            'Apple',
            919)
        );

        $manager->persist($this->generateSmartphone(
            'iPhone XR Noir 128 Go',
            'Apple',
            589)
        );

        $manager->persist($this->generateSmartphone(
            'iPhone 11 Pro Vert nuit 64 Go',
            'Apple',
            899)
        );

        $manager->persist($this->generateSmartphone(
            'iPhone 12 Pro Max Bleu pacifique 128 Go',
            'Apple',
            1259)
        );

        $manager->persist($this->generateSmartphone(
            'iPhone 12 mini Mauve 128 Go',
            'Apple',
            699)
        );

        $manager->persist($this->generateSmartphone(
            'Galaxy Z Flip 5G Bronze',
            'Samsung',
            1159)
        );

        $manager->persist($this->generateSmartphone(
            'Galaxy S20 FE 5G Bleu',
            'Samsung',
            649)
        );

        $manager->persist($this->generateSmartphone(
            'Galaxy Z Fold 2 5G Noir',
            'Samsung',
            1799)
        );

        $manager->persist($this->generateSmartphone(
            'P40 5G 128 Go',
            'Huawei',
            409)
        );

        $manager->persist($this->generateSmartphone(
            'P40 Pro Noir 5G 256 Go',
            'Huawei',
            449)
        );

        $manager->persist($this->generateSmartphone(
            'Redmi Note 9 Pro Gris',
            'Xiaomi',
            219)
        );

        $manager->persist($this->generateSmartphone(
            'Moto G50 Gris',
            'Motorola',
            249)
        );

        $manager->persist($this->generateSmartphone(
            'Xperia 10 III 5G Noir',
            'Sony',
            429)
        );

        $manager->flush();
    }
}
