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

class ProductController extends AbstractFOSRestController
{
    /**
     * Product List
     *
     * Return the list of all products.
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
     *
     * @View(serializerGroups={"GET_PRODUCT_LIST"})
     *
     * @OA\Tag(name="Products")
     * @Security(name="Bearer")
     * @OA\Response(
     *     response=200,
     *     description="Return the list of all products.",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=Products::class, groups={"GET_PRODUCT_LIST"}, ))
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found or expired."
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository(Product::class)->search(
            $paramFetcher->get('offset'),
            $paramFetcher->get('limit')
        );

        return new Products($pager);
    }

    /**
     * Product Details
     *
     * Return the details of a product
     *
     * @Get(
     *     path="/products/{id}",
     *     name="product_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @View(serializerGroups={"GET_PRODUCT_SHOW"})
     *
     * @OA\Tag(name="Products")
     * @Security(name="Bearer")
     * @OA\Response(
     *     response=200,
     *     description="Return the details of a product.",
     *     @OA\JsonContent(ref=@Model(type=Product::class, groups={"GET_PRODUCT_SHOW"}))
     * )
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found or expired."
     * )
     */
    public function showAction(Product $product)
    {
        return $product;
    }
}