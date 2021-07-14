<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CustomerFixtures extends Fixture
{
    public const ORANGE_CUSTOMER_REFERENCE = 'orange-customer';

    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
        $this->faker->seed(4746);
    }

    public function load(ObjectManager $manager)
    {
        $orangeCustomer = new Customer();
        $orangeCustomer->setCustomerNumber($this->faker->unique()->numberBetween(0000000000, 9999999999));
        $orangeCustomer->setCompanyName('Orange');
        $orangeCustomer->setPassword('password');
        $manager->persist($orangeCustomer);

        $manager->flush();

        $this->addReference(self::ORANGE_CUSTOMER_REFERENCE, $orangeCustomer);
    }
}