<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *         "user_show",
 *         parameters={
 *             "user_id"="expr(object.getId())",
 *             "customer_id"="expr(object.getCustomer().getId())"
 *         },
 *         absolute=true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_USER_LIST", "GET_USER_SHOW"})
 * )
 * @Hateoas\Relation(
 *     "create",
 *     href=@Hateoas\Route(
 *         "user_create",
 *         parameters={
 *             "id"="expr(object.getCustomer().getId())"
 *         },
 *         absolute=true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_USER_LIST", "GET_USER_SHOW"})
 * )
 * @Hateoas\Relation(
 *     "delete",
 *     href=@Hateoas\Route(
 *         "user_delete",
 *         parameters={
 *             "user_id"="expr(object.getId())",
 *             "customer_id"="expr(object.getCustomer().getId())"
 *         },
 *         absolute=true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_USER_LIST", "GET_USER_SHOW"})
 * )
 * @Hateoas\Relation(
 *     "customer",
 *     embedded=@Hateoas\Embedded("expr(object.getCustomer())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_USER_LIST", "GET_USER_SHOW"})
 * )
 * @Hateoas\Relation(
 *     "authenticated_customer",
 *     embedded=@Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_USER_SHOW"})
 * )
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"GET_USER_LIST", "GET_USER_SHOW"})
     */
    private $id;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="users", fetch="EAGER")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     *
     * @Serializer\Exclude
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     *
     * @Serializer\Groups({"GET_USER_LIST", "GET_USER_SHOW"})
     *
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/0[0-9]{9}/", message="Your phone number is not correctly formatted.")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     *
     * @Serializer\Groups({"GET_USER_LIST", "GET_USER_SHOW"})
     *
     * @Assert\NotBlank
     * @Assert\Email(message="Your email '{{ value }}' is not a valid email.")
     * @Assert\Length(max=100, maxMessage="Your email cannot be longer than {{ limit }} characters")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Serializer\Groups({"GET_USER_LIST", "GET_USER_SHOW"})
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     maxMessage="Your first name must be at least {{ limit }} characters long",
     *     maxMessage="Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Serializer\Groups({"GET_USER_LIST", "GET_USER_SHOW"})
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     maxMessage="Your last name must be at least {{ limit }} characters long",
     *     maxMessage="Your last name cannot be longer than {{ limit }} characters"
     * )
     */
    private $lastName;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Serializer\Groups({"GET_USER_SHOW"})
     */
    private $registeredAt;

    /**
     * Get user ID.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get customer that owns the user.
     *
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * Set customer that owns the user.
     *
     * @param Customer $customer
     *
     * @return $this
     */
    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get user phone.
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Set user phone.
     *
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get user email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set user email.
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get user first name.
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set user first name.
     *
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get user last name.
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set user last name.
     *
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get user registration datetime.
     *
     * @return DateTime
     */
    public function getRegisteredAt(): DateTime
    {
        return $this->registeredAt;
    }

    /**
     * Get user registration datetime.
     *
     * @param DateTime $registeredAt
     *
     * @return $this
     */
    public function setRegisteredAt(DateTime $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }
}