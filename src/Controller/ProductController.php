<?php


namespace App\Controller;


use App\Entity\Product;
use App\Representation\Products;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Get(path="/products", name="product_list")
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
     * @View
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository(Product::class)->search(
            $paramFetcher->get('offset'),
            $paramFetcher->get('limit')
        );

        return new Products($pager);
    }
}