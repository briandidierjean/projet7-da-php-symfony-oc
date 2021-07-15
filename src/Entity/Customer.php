<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({
     *     "GET_USER_LIST",
     *     "GET_USER_SHOW",
     *     "GET_PRODUCT_LIST",
     *     "GET_PRODUCT_SHOW"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     *
     * @Serializer\Groups({
     *     "GET_USER_LIST",
     *     "GET_USER_SHOW",
     *     "GET_PRODUCT_LIST",
     *     "GET_PRODUCT_SHOW"
     * })
     */
    private $customerNumber;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     *
     * @Serializer\Groups({
     *     "GET_USER_LIST",
     *     "GET_USER_SHOW",
     *     "GET_PRODUCT_LIST",
     *     "GET_PRODUCT_SHOW"
     * })
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @Serializer\Exclude
     */
    private $password;

    /**
     * @Serializer\Exclude
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="customer")
     *
     * @Serializer\Exclude
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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

    public function getUserIdentifier(): string
    {
        return $this->getCustomerNumber();
    }

    public function getUsername(): string
    {
        return $this->getCustomerNumber();
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }
}