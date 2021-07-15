<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixtures extends Fixture
{
    public const OCTELECOM_CUSTOMER_REFERENCE = 'orange-customer';

    private $userPasswordHasher;
    private $faker;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;

        $this->faker = Faker\Factory::create('fr_FR');
        $this->faker->seed(4746);
    }

    public function load(ObjectManager $manager)
    {
        $octelecomCustomer = new Customer();
        $octelecomCustomer->setCustomerNumber($this->faker->unique()->numberBetween(0000000000, 9999999999));
        $octelecomCustomer->setCompanyName('OCTelecom');
        $octelecomCustomer->setPassword(
            $this->userPasswordHasher->hashPassword($octelecomCustomer, 'bilemo')
        );
        $manager->persist($octelecomCustomer);

        $otherCustomer = new Customer();
        $otherCustomer->setCustomerNumber($this->faker->unique()->numberBetween(0000000000, 9999999999));
        $otherCustomer->setCompanyName('Other');
        $otherCustomer->setPassword(
            $this->userPasswordHasher->hashPassword($otherCustomer, 'bilemo')
        );
        $manager->persist($otherCustomer);

        $manager->flush();

        $this->addReference(self::OCTELECOM_CUSTOMER_REFERENCE, $octelecomCustomer);
    }
}