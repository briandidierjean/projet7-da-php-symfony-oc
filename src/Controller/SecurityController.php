<?php


namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Post;
use OpenApi\Annotations as OA;

class SecurityController extends AbstractFOSRestController
{
    /**
     * Login
     *
     * Return a Bearer Token.
     *
     * @Post(path="/login")
     *
     * @OA\Tag(name="Security")
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(property="customer_number", type="string", example="8XXXXXXXXX"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="Return the Bearer Token.",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="token",
     *             type="string"
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="The credentials are invalid."
     * )
     */
    public function loginAction()
    {
        throw new \Exception('This should never be reached.');
    }
}