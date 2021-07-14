<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"GET_USER_LIST"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="users", cascade={"all"}, fetch="EAGER")
     *
     * @Serializer\Groups({"GET_USER_LIST"})
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     *
     * @Serializer\Groups({"GET_USER_LIST"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     *
     * @Serializer\Groups({"GET_USER_LIST"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Serializer\Groups({"GET_USER_LIST"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Serializer\Groups({"GET_USER_LIST"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $registeredAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getRegisteredAt(): DateTime
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(DateTime $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }
}