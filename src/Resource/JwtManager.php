<?php


namespace App\Resource;

use Lindelius\JWT\Algorithm\HMAC\HS256;
use Lindelius\JWT\JWT;

class JwtManager extends JWT
{
    use HS256;
}
