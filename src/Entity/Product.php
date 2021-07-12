<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
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
    private $reference;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $brand;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="products", cascade={"all"}, fetch="EAGER")
     */
    private $category;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $unitPriceOffTax;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $VATRate100;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $stock;

    public function getId(): int
    {
        return $this->id;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ProductCategory
    {
        return $this->category;
    }

    public function setCategory(ProductCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUnitPriceOffTax(): int
    {
        return $this->unitPriceOffTax / 100;
    }

    public function setUnitPriceOffTax(int $unitPriceOffTax): self
    {
        $this->unitPriceOffTax = round($unitPriceOffTax, 2) * 100;

        return $this;
    }

    public function getVATRate100(): ?int
    {
        return $this->VATRate100 / 100;
    }

    public function setVATRate100(?int $VATRate100): self
    {
        $this->VATRate100 = round($VATRate100, 2) * 100;

        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}