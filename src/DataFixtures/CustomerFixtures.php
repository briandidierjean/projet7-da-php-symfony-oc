<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CustomerFixtures extends Fixture
{
    public const OCTELECOM_CUSTOMER_REFERENCE = 'orange-customer';

    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
        $this->faker->seed(4746);
    }

    public function load(ObjectManager $manager)
    {
        $octelecomCustomer = new Customer();
        $octelecomCustomer->setCustomerNumber($this->faker->unique()->numberBetween(0000000000, 9999999999));
        $octelecomCustomer->setCompanyName('OCTelecom');
        $octelecomCustomer->setPassword('password');
        $manager->persist($octelecomCustomer);

        $manager->flush();

        $this->addReference(self::OCTELECOM_CUSTOMER_REFERENCE, $octelecomCustomer);
    }
}