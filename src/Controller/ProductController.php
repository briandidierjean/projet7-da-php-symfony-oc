<?php


namespace App\Controller;

use App\Entity\Product;
use App\Representation\Products;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ProductController
 *
 * @package App\Controller
 */
class ProductController extends AbstractFOSRestController
{
    /**
     * Return the list of all products.
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Products
     *
     * @Get(path="/products", name="product_list")
     *
     * @QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset."
     * )
     * @QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="5",
     *     description="The maximum of products per page."
     * )
     * @QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]*",
     *     nullable=true,
     *     description="The product keyword to search for."
     * )
     * @QueryParam(
     *     name="brand",
     *     requirements="[a-zA-Z0-9]*",
     *     nullable=true,
     *     description="The product brand to search for."
     * )
     * @QueryParam(
     *     name="category_name",
     *     requirements="[a-zA-Z0-9]*",
     *     nullable=true,
     *     description="The product category name to search for."
     * )
     * @QueryParam(
     *     name="in_stock",
     *     requirements="true|false",
     *     default="false",
     *     description="Filter the products that are in stock (true or false)."
     * )
     *
     * @View(serializerGroups={"GET_PRODUCT_LIST"})
     *
     * @OA\Tag(name="Product")
     * @Security(name="Bearer")
     * @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="keyword",
     *     in="query",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="brand",
     *     in="query",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="category_name",
     *     in="query",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="in_stock",
     *     in="query",
     *     @OA\Schema(type="boolean")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Return the list of the products.",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=Products::class, groups={"GET_PRODUCT_LIST"}, ))
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="The JWT Token is invalid."
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $inStock = false;
        if ($paramFetcher->get('in_stock') === 'true') $inStock = true;

        $pager = $this->getDoctrine()->getRepository(Product::class)->search(
            $paramFetcher->get('offset'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('keyword'),
            $paramFetcher->get('brand'),
            $paramFetcher->get('category_name'),
            $inStock
        );

        return new Products(
            $pager, $paramFetcher->get('keyword'),
            $paramFetcher->get('brand'),
            $paramFetcher->get('category_name'),
            $inStock
        );
    }

    /**
     * Return the details of a product.
     *
     * @param Product|null $product
     *
     * @return Product
     *
     * @throws NotFoundHttpException
     *
     * @Get(
     *     path="/products/{id}",
     *     name="product_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @View(serializerGroups={"GET_PRODUCT_SHOW"})
     *
     * @OA\Tag(name="Product")
     * @Security(name="Bearer")
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The product ID.",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Return the details of the product.",
     *     @OA\JsonContent(ref=@Model(type=Product::class, groups={"GET_PRODUCT_SHOW"})),
     * )
     * @OA\Response(
     *     response=401,
     *     description="The JWT Token is invalid."
     * )
     * @OA\Response(
     *     response=404,
     *     description="The product was not found."
     * )
     */
    public function showAction(Product $product = null)
    {
        if (!$product) {
            throw new NotFoundHttpException('Product Not Found');
        }

        return $product;
    }
}