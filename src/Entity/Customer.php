<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     */
    private $customerNumber; // TODO: Change type in classes diagram

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomerNumber(): string
    {
        return $this->customerNumber;
    }

    public function setCustomerNumber(string $customerNumber): self
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}