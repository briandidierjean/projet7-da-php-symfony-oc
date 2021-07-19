<?php


namespace App\Representation;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Pagerfanta\Pagerfanta;

/**
 * Class Products
 *
 * @package App\Representation
 *
 * @Hateoas\Relation(
 *     "meta",
 *     embedded=@Hateoas\Embedded("expr(object.getMeta())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_PRODUCT_LIST"})
 * )
 * @Hateoas\Relation(
 *     "authenticated_customer",
 *     embedded=@Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_PRODUCT_LIST"})
 * )
 */
class Products
{
    /**
     * @var array
     *
     * @Serializer\Groups({"GET_PRODUCT_LIST"})
     * @Serializer\Type("array<App\Entity\Product>")
     */
    public $data;

    /**
     * @var array
     */
    public $meta;

    /**
     * Products constructor.
     *
     * @param Pagerfanta $pager
     * @param string $keyword
     * @param string $brand
     * @param string $categoryName
     * @param bool $inStock
     */
    public function __construct(
        Pagerfanta $pager,
        string $keyword,
        string $brand,
        string $categoryName,
        bool $inStock
    )
    {
        $this->data = $pager->getCurrentPageResults();

        $this->addMeta('limit', $pager->getMaxPerPage());
        $this->addMeta('current_items', count($pager->getCurrentPageResults()));
        $this->addMeta('total_items', $pager->getNbResults());
        $this->addMeta('offset', $pager->getCurrentPageOffsetStart());
        if ($keyword) $this->addMeta('keyword', $keyword);
        if ($brand) $this->addMeta('brand', $brand);
        if ($categoryName) $this->addMeta('category', $categoryName);
        if ($inStock) $this->addMeta('in_stock', $inStock);
    }

    /**
     * Add values to meta data.
     *
     * @param string $name
     * @param string $value
     */
    public function addMeta(string $name, string $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta,
            use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    /**
     * Get meta data.
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set meta data.
     *
     * @param string $name
     * @param string $value
     */
    public function setMeta(string $name, string $value)
    {
        $this->meta[$name] = $value;
    }
}