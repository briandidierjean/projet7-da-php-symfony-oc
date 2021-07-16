<?php


namespace App\DataFixtures;


use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixtures extends Fixture
{
    public const OCTELECOM_CUSTOMER_REFERENCE = 'orange-customer';

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

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