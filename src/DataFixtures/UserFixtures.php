<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

/**
 * Class UserFixtures
 *
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var Faker\Generator
     */
    private $faker;

    /**
     * UserFixtures constructor.
     */
    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
        $this->faker->seed(5486);
    }

    /**
     * Format a phone number to a French number.
     *
     * @param string $phoneNumber
     *
     * @return string
     */
    public function formatPhoneNumber(string $phoneNumber)
    {
        return str_replace(
            ' ', '', preg_replace(
                '/^\+33( \(0\))?/', '0', $phoneNumber
            )
        );
    }

    /**
     * Load users data.
     *
     * @param ObjectManager $manager
     */
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