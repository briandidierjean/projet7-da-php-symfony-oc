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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @ParamConverter("customer", options={"id" = "customer_id"})
     * @ParamConverter("user", options={"id" = "user_id"})
     *
     * @View(serializerGroups={"GET_USER_SHOW"})
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
            throw new NotFoundHttpException('Not Found');
        }

        return $user;
    }

    /**
     * @Post(path="/customers/{id}/users", name="user_create")
     *
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @View
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
                    'Field %s: %s. ',
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
     */
    public function deleteAction(Customer $customer = null, User $user = null)
    {
        if (!$customer || $this->getUser()->getId() !== $customer->getId()) {
            $message = sprintf(
                '%s cannot delete users of another customer.',
                $this->getUser()->getCompanyName()
            );
            throw new ForbiddenException($message);
        }

        if (!$user) {
            throw new NotFoundHttpException('Not Found');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
    }
}