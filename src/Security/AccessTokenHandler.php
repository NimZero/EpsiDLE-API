<?php

namespace App\Security;

use App\Repository\UserRepository;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private Auth $auth,
        private UserRepository $userRepository,
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($accessToken);
        } catch (FailedToVerifyToken $e) {
            throw new BadCredentialsException($e->getMessage());
        }

        $uid = $verifiedIdToken->claims()->get('sub');

        return new UserBadge($uid);
    }
}
