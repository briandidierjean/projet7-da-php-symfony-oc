<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
        $this->faker->seed(5486);
    }

    public function formatPhoneNumber($phoneNumber)
    {
        return str_replace(
            ' ', '', preg_replace(
                '/^\+33( \(0\))?/', '0', $phoneNumber
            )
        );
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setCustomer($this->getReference(CustomerFixtures::OCTELECOM_CUSTOMER_REFERENCE));
            $user->setPhone($this->formatPhoneNumber($this->faker->unique()->mobileNumber));
            $user->setEmail($this->faker->unique()->safeEmail);
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setRegisteredAt($this->faker->dateTimeThisDecade());
            $manager->persist($user);
        }

        $manager->flush();
    }
}