<?php


namespace App\Representation;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Pagerfanta\Pagerfanta;

/**
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
     * @Serializer\Groups({"GET_PRODUCT_LIST"})
     * @Serializer\Type("array<App\Entity\Product>")
     */
    public $data;

    public $meta;

    public function __construct(Pagerfanta $pager, $keyword, $brand, $categoryName, $in_stock)
    {
        $this->data = $pager->getCurrentPageResults();

        $this->addMeta('limit', $pager->getMaxPerPage());
        $this->addMeta('current_items', count($pager->getCurrentPageResults()));
        $this->addMeta('total_items', $pager->getNbResults());
        $this->addMeta('offset', $pager->getCurrentPageOffsetStart());
        if ($keyword) $this->addMeta('keyword', $keyword);
        if ($brand) $this->addMeta('brand', $brand);
        if ($categoryName) $this->addMeta('category', $categoryName);
        if ($in_stock === 'true') $this->addMeta('in_stock', $in_stock);
    }

    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta,
            use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}