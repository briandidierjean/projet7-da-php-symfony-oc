<?php


namespace App\Representation;

use JMS\Serializer\Annotation\Type;
use Pagerfanta\Pagerfanta;

class Products
{
    /**
     * @Type("array<App\Entity\Product>")
     */
    public $data;
    public $meta;

    public function __construct(Pagerfanta $pager)
    {
        $this->data = $pager->getCurrentPageResults();

        $this->addMeta('limit', $pager->getMaxPerPage());
        $this->addMeta('current_items', count($pager->getCurrentPageResults()));
        $this->addMeta('total_items', $pager->getNbResults());
        $this->addMeta('offset', $pager->getCurrentPageOffsetStart());
    }

    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \ÒLogicException(sprintf('This meta already exists. You are trying to override this meta,
            use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}