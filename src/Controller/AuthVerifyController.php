<?php

namespace App\Controller;

use App\Resource\JwtManager;
use Exception;
use Lindelius\JWT\Exception\InvalidJwtException;
use Lindelius\JWT\Exception\JwtException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Trikoder\Bundle\OAuth2Bundle\League\Repository\ClientRepository;

/**
 * @Route("/api")
 */
class AuthVerifyController extends AbstractController
{
    /**
     * @var JwtManager
     */
    private $jwtManager;

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * AuthController constructor.
     * @param JwtManager $jwtManager
     * @param ClientRepository $clientRepository
     */
    public function __construct(JwtManager $jwtManager, ClientRepository $clientRepository)
    {
        $this->jwtManager = $jwtManager;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @Route("/verify", name="auth_verify")
     * @param Request $request
     * @return Response
     * @throws InvalidJwtException
     * @throws JwtException
     */
    public function verify(Request $request): Response
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        $client = $this->jwtManager::decode($token)->getClaim('aud');
        $client = $this->clientRepository->getClientEntity($client);

        if (is_null($client)) {
            return new Response(null, 403);
        }

        return new Response(null, 200);
    }
}
