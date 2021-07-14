<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Exception\ResourceValidationException;
use App\Representation\Users;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

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

    /**
     * @Get(
     *     path="/customers/{customer_id}/users/{user_id}",
     *     name="user_show",
     *     requirements={"customerId"="\d+", "userId"="\d+"}
     * )
     *
     * @ParamConverter("user", options={"id" = "user_id"})
     *
     * @View(serializerGroups={"GET_USER_SHOW"})
     */
    public function showAction(User $user)
    {
        return $user;
    }

    /**
     * @Post(path="/customers/{id}/users", name="user_create")
     *
     * @View(StatusCode=201)
     *
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function createAction(User $user, Customer $customer, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. ';
            foreach ($violations as $violation) {
                $message .= sprintf(
                    'Field %s: %s ',
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                );
            }

            throw new ResourceValidationException($message);
        }

        $user->setCustomer($customer);
        $user->setRegisteredAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->view(
            $user,
            Response::HTTP_CREATED,
            ['Location' => $this->generateUrl(
                'user_show',
                [
                    'user_id' => $user->getId(),
                    'customer_id' => $customer->getId(),
                    UrlGeneratorInterface::ABSOLUTE_URL
                ]
            )]
        );
    }
}