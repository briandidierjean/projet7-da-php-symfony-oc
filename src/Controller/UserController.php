<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Representation\Users;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

class UserController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path="/customers/{id}/users",
     *     name="user_list",
     *     requirements={"id"="\d+"}
     * )
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
     *     default="10",
     *     description="The maximum of user per page."
     * )
     *
     * @View(serializerGroups={"GET_USER_LIST"})
     */
    public function listAction(Customer $customer, ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository(User::class)->search(
            $customer,
            $paramFetcher->get('offset'),
            $paramFetcher->get('limit')
        );

        return new Users($pager);
    }
}