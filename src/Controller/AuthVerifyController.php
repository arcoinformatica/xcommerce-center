<?php

namespace App\Controller;

use App\Resource\JwtManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * AuthController constructor.
     * @param JwtManager $jwtManager
     */
    public function __construct(JwtManager $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    /**
     * @Route("/verify", name="auth_verify")
     * @param Request $request
     * @return Response
     * @throws \Lindelius\JWT\Exception\InvalidJwtException
     * @throws \Lindelius\JWT\Exception\JwtException
     */
    public function verify(Request $request): Response
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        $client = $this->jwtManager::decode($token)->getClaim('aud');

        // TODO: Implementar a busca do client com Repository
        $client = null;

        if (is_null($client)) {
            return new Response(null, 403);
        }

        return new Response(null, 200);
    }
}
