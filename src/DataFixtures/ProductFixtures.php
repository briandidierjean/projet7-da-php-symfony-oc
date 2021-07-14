<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $product1 = new Product();
        $product1->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product1->setName('iPhone 12 Mauve 64 Go');
        $product1->setBrand('Apple');
        $product1->setDescription($faker->paragraph(5));
        $product1->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product1->setUnitPriceOffTax(799);
        $product1->setVATRate100(20);
        $product1->setStock($faker->randomDigit);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product2->setName('iPhone SE Noir 64 Go');
        $product2->setBrand('Apple');
        $product2->setDescription($faker->paragraph(5));
        $product2->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product2->setUnitPriceOffTax(500);
        $product2->setVATRate100(20);
        $product2->setStock($faker->randomDigit);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product3->setName('iPhone 12 Noir 128 Go');
        $product3->setBrand('Apple');
        $product3->setDescription($faker->paragraph(5));
        $product3->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product3->setUnitPriceOffTax(919);
        $product3->setVATRate100(20);
        $product3->setStock($faker->randomDigit);
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product4->setName('iPhone XR Noir 128 Go');
        $product4->setBrand('Apple');
        $product4->setDescription($faker->paragraph(5));
        $product4->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product4->setUnitPriceOffTax(589);
        $product4->setVATRate100(20);
        $product4->setStock($faker->randomDigit);
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product5->setName('iPhone 11 Pro Vert nuit 64 Go');
        $product5->setBrand('Apple');
        $product5->setDescription($faker->paragraph(5));
        $product5->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product5->setUnitPriceOffTax(899);
        $product5->setVATRate100(20);
        $product5->setStock($faker->randomDigit);
        $manager->persist($product5);

        $product6 = new Product();
        $product6->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product6->setName('iPhone 12 Pro Max bleu pacifique 128 Go');
        $product6->setBrand('Apple');
        $product6->setDescription($faker->paragraph(5));
        $product6->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product6->setUnitPriceOffTax(1259);
        $product6->setVATRate100(20);
        $product6->setStock($faker->randomDigit);
        $manager->persist($product6);

        $product7 = new Product();
        $product7->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product7->setName('iPhone 12 mini Mauve 128 Go');
        $product7->setBrand('Apple');
        $product7->setDescription($faker->paragraph(5));
        $product7->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product7->setUnitPriceOffTax(699);
        $product7->setVATRate100(20);
        $product7->setStock($faker->randomDigit);
        $manager->persist($product7);

        $product8 = new Product();
        $product8->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product8->setName('Galaxy Z Flip 5G Bronze');
        $product8->setBrand('Samsung');
        $product8->setDescription($faker->paragraph(5));
        $product8->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product8->setUnitPriceOffTax(1159);
        $product8->setVATRate100(20);
        $product8->setStock($faker->randomDigit);
        $manager->persist($product8);

        $product9 = new Product();
        $product9->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product9->setName('Galaxy S20 FE 5G Bleu');
        $product9->setBrand('Samsung');
        $product9->setDescription($faker->paragraph(5));
        $product9->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product9->setUnitPriceOffTax(649);
        $product9->setVATRate100(20);
        $product9->setStock($faker->randomDigit);
        $manager->persist($product9);

        $product10 = new Product();
        $product10->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product10->setName('Galaxy Z Fold2 5G noir');
        $product10->setBrand('Samsung');
        $product10->setDescription($faker->paragraph(5));
        $product10->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product10->setUnitPriceOffTax(1799);
        $product10->setVATRate100(20);
        $product10->setStock($faker->randomDigit);
        $manager->persist($product10);

        $product11 = new Product();
        $product11->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product11->setName('P40 5G 128 Go');
        $product11->setBrand('Huawei');
        $product11->setDescription($faker->paragraph(5));
        $product11->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product11->setUnitPriceOffTax(409);
        $product11->setVATRate100(20);
        $product11->setStock($faker->randomDigit);
        $manager->persist($product11);

        $product12 = new Product();
        $product12->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product12->setName('P40 Pro Noir 5G 256 Go');
        $product12->setBrand('Huawei');
        $product12->setDescription($faker->paragraph(5));
        $product12->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product12->setUnitPriceOffTax(449);
        $product12->setVATRate100(20);
        $product12->setStock($faker->randomDigit);
        $manager->persist($product12);

        $product13 = new Product();
        $product13->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product13->setName('Xiaomi Redmi Note 9 Pro Gris');
        $product13->setBrand('Xiaomi');
        $product13->setDescription($faker->paragraph(5));
        $product13->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product13->setUnitPriceOffTax(219);
        $product13->setVATRate100(20);
        $product13->setStock($faker->randomDigit);
        $manager->persist($product13);

        $product14 = new Product();
        $product14->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product14->setName('Moto G50 Gris');
        $product14->setBrand('Motorola');
        $product14->setDescription($faker->paragraph(5));
        $product14->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product14->setUnitPriceOffTax(249);
        $product14->setVATRate100(20);
        $product14->setStock($faker->randomDigit);
        $manager->persist($product14);

        $product15 = new Product();
        $product15->setReference(strtoupper(substr($faker->unique()->uuid(), 0, 50)));
        $product15->setName('Xperia 10 III 5G Noir');
        $product15->setBrand('Sony');
        $product15->setDescription($faker->paragraph(5));
        $product15->setCategory($this->getReference(ProductCategoryFixtures::PRODUCT_CATEGORY_1_REFERENCE));
        $product15->setUnitPriceOffTax(429);
        $product15->setVATRate100(20);
        $product15->setStock($faker->randomDigit);
        $manager->persist($product15);

        $manager->flush();
    }
}
