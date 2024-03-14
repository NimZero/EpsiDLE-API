<?php

namespace App\Security;

use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppFirebaseAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private Auth $auth,
    ) {
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response {
        return new RedirectResponse($this->getLoginUrl());
    }

    public function supports(Request $request): ?bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
        && $request->query->has('token');
    }

    public function authenticate(Request $request): Passport
    {
        $token = $request->query->get('token');

        if (null === $token || '' === $token) {
            throw new CustomUserMessageAuthenticationException('No token');
        }

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($token);
        } catch (FailedToVerifyToken $e) {
            dd('fail', $e);
            throw new CustomUserMessageAuthenticationException($e->getMessage());
        }

        $uid = $verifiedIdToken->claims()->get('sub');

        return new SelfValidatingPassport(new UserBadge($uid));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if ($request->hasSession()) {
            $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
        }

        return new RedirectResponse($this->getLoginUrl());
    }

    private function getLoginUrl(): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE, referenceType: UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
