<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FirebaseUserProvider implements UserProviderInterface
{
    private UserRepository $userRepository;

    public function __construct(
        private Auth $auth,
        private EntityManagerInterface $em,
    ) {
        $this->userRepository = $em->getRepository(User::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {
            $firebaseUser = $this->auth->getUser($identifier);
        } catch (UserNotFound) {
            throw new UserNotFoundException();
        }

        $user = $this->userRepository->findOneBy(['firebaseUUID' => $firebaseUser->uid]);
        if ($user) {
            return $user;
        }

        $user = new User();
        $user
            ->setFirebaseUUID($firebaseUser->uid)
            ->setEmail($firebaseUser->email)
            ->setName($firebaseUser->displayName);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getFirebaseUUID());
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }
}
