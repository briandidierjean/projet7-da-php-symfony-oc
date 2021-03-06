<?php


namespace App\Representation;


use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Pagerfanta\Pagerfanta;

/**
 * Class Users
 *
 * @package App\Representation
 *
 * @Hateoas\Relation(
 *     "meta",
 *     embedded=@Hateoas\Embedded("expr(object.getMeta())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_USER_LIST"})
 * )
 * @Hateoas\Relation(
 *     "authenticated_customer",
 *     embedded=@Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *     exclusion=@Hateoas\Exclusion(groups={"GET_USER_LIST"})
 * )
 */
class Users
{
    /**
     * @var array
     *
     * @Serializer\Groups({"GET_USER_LIST"})
     * @Serializer\Type("array<App\Entity\User>")
     */
    public $data;

    /**
     * @var array
     */
    public $meta;

    /**
     * Users constructor.
     *
     * @param Pagerfanta $pager
     * @param string $order
     * @param string|null $firstName
     * @param string|null $lastName
     */
    public function __construct(Pagerfanta $pager, string $order, ?string $firstName, ?string $lastName)
    {
        $this->data = $pager->getCurrentPageResults();

        $this->addMeta('limit', $pager->getMaxPerPage());
        $this->addMeta('current_items', count($pager->getCurrentPageResults()));
        $this->addMeta('total_items', $pager->getNbResults());
        $this->addMeta('offset', $pager->getCurrentPageOffsetStart());
        $this->addMeta('order', $order);
        if ($firstName) $this->addMeta('first_name', $firstName);
        if ($lastName) $this->addMeta('last_name', $lastName);
    }

    /**
     * Add values to meta data.
     *
     * @param string $name
     * @param string $value
     */
    public function addMeta($name, $value)
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
    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}