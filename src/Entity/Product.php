<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Product
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *         "product_show",
 *         parameters={"id"="expr(object.getId())"},
 *         absolute=true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
 * )
 * @Hateoas\Relation(
 *     "category",
 *     embedded=@Hateoas\Embedded("expr(object.getCategory())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
 * )
 * @Hateoas\Relation(
 *     "authenticated_customer",
 *     embedded=@Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_PRODUCT_SHOW"})
 * )
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     *
     * @Serializer\Groups({"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     *
     * @Serializer\Groups({"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Serializer\Groups({"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Groups({"GET_PRODUCT_SHOW"})
     */
    private $description;

    /**
     * @var ProductCategory
     *
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="products", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @Serializer\Groups({"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
     * @Serializer\Accessor(getter="getUnitPriceOffTax")
     */
    private $unitPriceOffTax;

    /**
     * @var int
     *
     * @ORM\Column(name="vat_rate_100", type="integer", nullable=true)
     *
     * @Serializer\Groups({"GET_PRODUCT_SHOW"})
     * @Serializer\SerializedName("vat_rate_100")
     * @Serializer\Accessor(getter="getVATRate100")
     */
    private $VATRate100;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @Serializer\Groups({"GET_PRODUCT_LIST", "GET_PRODUCT_SHOW"})
     */
    private $stock;

    /**
     * Get product ID.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get product reference.
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Set product reference.
     *
     * @param string $reference
     *
     * @return $this
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get product name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set product name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get product brand.
     *
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * Set product brand.
     *
     * @param string|null $brand
     *
     * @return $this
     */
    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get product description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set product description
     *
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get product category.
     *
     * @return ProductCategory
     */
    public function getCategory(): ProductCategory
    {
        return $this->category;
    }

    /**
     * Set product category.
     *
     * @param ProductCategory $category
     *
     * @return $this
     */
    public function setCategory(ProductCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get product price off tax.
     *
     * @return int
     */
    public function getUnitPriceOffTax(): int
    {
        return $this->unitPriceOffTax / 100;
    }

    /**
     * Set product price off tax.
     *
     * @param int $unitPriceOffTax
     *
     * @return $this
     */
    public function setUnitPriceOffTax(int $unitPriceOffTax): self
    {
        $this->unitPriceOffTax = round($unitPriceOffTax, 2) * 100;

        return $this;
    }

    /**
     * Get product VAT.
     *
     * @return int|null
     */
    public function getVATRate100(): ?int
    {
        return $this->VATRate100 / 100;
    }

    /**
     * Set product VAT.
     *
     * @param int|null $VATRate100
     *
     * @return $this
     */
    public function setVATRate100(?int $VATRate100): self
    {
        $this->VATRate100 = round($VATRate100, 2) * 100;

        return $this;
    }

    /**
     * Get how many product that are in stock.
     *
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * Get how many product that are in stock.
     *
     * @param int $stock
     *
     * @return $this
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}