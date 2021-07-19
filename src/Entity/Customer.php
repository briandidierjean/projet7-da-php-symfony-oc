<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Customer
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
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
     * @var string
     *
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
     * @var string
     *
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
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @Serializer\Exclude
     */
    private $password;

    /**
     * @var array
     *
     * @Serializer\Exclude
     */
    private $roles = [];

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="customer")
     *
     * @Serializer\Exclude
     */
    private $users;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * Get customer ID.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get customer number.
     *
     * @return string
     */
    public function getCustomerNumber(): string
    {
        return $this->customerNumber;
    }

    /**
     * Set customer number.
     *
     * @param string $customerNumber
     *
     * @return $this
     */
    public function setCustomerNumber(string $customerNumber): self
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    /**
     * Get customer company name.
     *
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * Set customer company name.
     *
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get customer identifier.
     *
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->getCustomerNumber();
    }

    /**
     * Get customer username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getCustomerNumber();
    }

    /**
     * Get customer password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set customer password.
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get customer roles.
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Set customer roles.
     *
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get customer users.
     *
     * @return ArrayCollection
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    /**
     * Get customer salt.
     *
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Erase customer credentials.
     */
    public function eraseCredentials()
    {
    }
}