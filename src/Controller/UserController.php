<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Exception\ForbiddenException;
use App\Exception\ResourceValidationException;
use App\Representation\Users;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class UserController extends AbstractFOSRestController
{
    /**
     * Customer's User List
     *
     * Return the list of all users that belong to a customer.
     *
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
     *     description="The maximum of users per page."
     * )
     * @QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="desc",
     *     description="Sort order by user's registration date (asc or desc)."
     * )
     * @QueryParam(
     *     name="first_name",
     *     requirements="[a-zA-Z]*",
     *     nullable=true,
     *     description="The user first name to search for."
     * )
     * @QueryParam(
     *     name="last_name",
     *     requirements="[a-zA-Z]*",
     *     nullable=true,
     *     description="The user last name to search for."
     * )
     *
     * @View(serializerGroups={"GET_USER_LIST"})
     *
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The customer ID.",
     *     @OA\Schema(type="integer")
     * )
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
     *     name="order",
     *     in="query",
     *     @OA\Schema(type="string", enum={"asc", "desc"})
     * )
     * @OA\Response(
     *     response=200,
     *     description="Return the list of the users",
     *     @OA\JsonContent(ref=@Model(type=Users::class, groups={"GET_USER_LIST"}))
     * )
     * @OA\Response(
     *     response=401,
     *     description="The JWT Token is invalid."
     * )
     * @OA\Response(
     *     response=403,
     *     description="These users do not belong to this customer."
     * )
     */
    public function listAction(Customer $customer = null, ParamFetcherInterface $paramFetcher)
    {
        if (!$customer || $this->getUser()->getId() !== $customer->getId()) {
            $message = sprintf(
                'These users do not belong to %s.',
                $this->getUser()->getCompanyName()
            );

            throw new ForbiddenException($message);
        }

        $pager = $this->getDoctrine()->getRepository(User::class)->search(
            $customer,
            $paramFetcher->get('offset'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('order'),
            $paramFetcher->get('first_name'),
            $paramFetcher->get('last_name')
        );

        return new Users(
            $pager,
            $paramFetcher->get('order'),
            $paramFetcher->get('first_name'),
            $paramFetcher->get('last_name')
        );
    }

    /**
     * Customer's User Details
     *
     * Return the details of a user that belongs to a customer.
     *
     * @Get(
     *     path="/customers/{customer_id}/users/{user_id}",
     *     name="user_show",
     *     requirements={"customerId"="\d+", "userId"="\d+"}
     * )
     *
     * @ParamConverter("customer", options={"id" = "customer_id"})
     * @ParamConverter("user", options={"id" = "user_id"})
     *
     * @View(serializerGroups={"GET_USER_SHOW"})
     *
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     * @OA\Parameter(
     *     name="customer_id",
     *     in="path",
     *     description="The customer ID.",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="user_id",
     *     in="path",
     *     description="The customer's user ID.",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Return the detail of the user",
     *     @OA\JsonContent(ref=@Model(type=User::class, groups={"GET_USER_SHOW"}))
     * )
     * @OA\Response(
     *     response=401,
     *     description="The JWT Token is invalid."
     * )
     * @OA\Response(
     *     response=403,
     *     description="This user does not belong to this customer."
     * )
     * @OA\Response(
     *     response=404,
     *     description="The user was not found."
     * )
     */
    public function showAction(Customer $customer = null, User $user = null)
    {
        if (!$customer || $this->getUser()->getId() !== $customer->getId()) {
            $message = sprintf(
                'This user does not belong to %s.',
                $this->getUser()->getCompanyName()
            );
            throw new ForbiddenException($message);
        }

        if (!$user) {
            throw new NotFoundHttpException('User Not Found');
        }

        return $user;
    }

    /**
     * Adding Customer's User
     *
     * Add a user for a customer.
     *
     * @Post(path="/customers/{id}/users", name="user_create")
     *
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @View
     *
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The customer ID.",
     *     @OA\Schema(type="integer")
     * )
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(property="phone", type="string", example="06XXXXXXXX"),
     *             @OA\Property(property="email", type="string", example="jeandupont@example.com"),
     *             @OA\Property(property="first_name", type="string", example="Jean"),
     *             @OA\Property(property="last_name", type="string", example="Dupont")
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="The user was successfully added.",
     *     @OA\JsonContent(ref=@Model(type=User::class)),
     * )
     * @OA\Response(
     *     response=401,
     *     description="The JWT Token is invalid."
     * )
     * @OA\Response(
     *     response=403,
     *     description="This customer cannot add users for another customer."
     * )
     * @OA\Response(
     *     response=400,
     *     description="The JSON sent contains invalid data."
     * )
     */
    public function createAction(User $user, Customer $customer = null, ConstraintViolationList $violations)
    {
        if (!$customer || $this->getUser()->getId() !== $customer->getId()) {
            $message = sprintf(
                '%s cannot add users for another customer.',
                $this->getUser()->getCompanyName()
            );
            throw new ForbiddenException($message);
        }

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
            ['Location' => $this->generateUrl('user_show', [
                'user_id' => $user->getId(),
                'customer_id' => $customer->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ])]
        );
    }

    /**
     * Deleting Customer's User
     *
     * Deleting a user from a customer.
     *
     * @Delete(
     *     path="/customers/{customer_id}/users/{user_id}",
     *     name="user_delete",
     *     requirements={"customerId"="\d+", "userId"="\d+"}
     * )
     *
     * @ParamConverter("customer", options={"id" = "customer_id"})
     * @ParamConverter("user", options={"id" = "user_id"})
     *
     * @View(StatusCode=204)
     *
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     * @OA\Parameter(
     *     name="customer_id",
     *     in="path",
     *     description="The customer ID.",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="user_id",
     *     in="path",
     *     description="The user ID.",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Response(
     *     response=204,
     *     description="The user was successfully deleted.",
     *     @OA\JsonContent(ref=@Model(type=User::class)),
     * )
     * @OA\Response(
     *     response=401,
     *     description="The JWT Token is invalid."
     * )
     * @OA\Response(
     *     response=403,
     *     description="This customer cannot delete users from another customer."
     * )
     */
    public function deleteAction(Customer $customer = null, User $user = null)
    {
        if (!$customer || $this->getUser()->getId() !== $customer->getId()) {
            $message = sprintf(
                '%s cannot delete users from another customer.',
                $this->getUser()->getCompanyName()
            );
            throw new ForbiddenException($message);
        }

        if (!$user) {
            throw new NotFoundHttpException('Not Found');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
    }
}