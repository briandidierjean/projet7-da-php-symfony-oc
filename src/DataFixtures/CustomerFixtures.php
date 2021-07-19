<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class CustomerFixtures
 *
 * @package App\DataFixtures
 */
class CustomerFixtures extends Fixture
{
    /**
     * @var string
     */
    public const OCTELECOM_CUSTOMER_REFERENCE = 'octelecom-customer';

    /**
     * @var UserPasswordHasherInterface
     */
    private $userPasswordHasher;

    /**
     * CustomerFixtures constructor.
     *
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * Load customers data.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $octelecomCustomer = new Customer();
        $octelecomCustomer->setCustomerNumber('8306368151');
        $octelecomCustomer->setCompanyName('OCTelecom');
        $octelecomCustomer->setPassword(
            $this->userPasswordHasher->hashPassword($octelecomCustomer, 'bilemo')
        );
        $this->addReference(self::OCTELECOM_CUSTOMER_REFERENCE, $octelecomCustomer);
        $manager->persist($octelecomCustomer);

        $manager->flush();
    }
}