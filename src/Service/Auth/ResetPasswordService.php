<?php

namespace App\Service\Auth;

use App\Entity\ForgetPassword;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $em
    ) {
    }

    public function editPassword(User $user): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPlainPassword() /* @phpstan-ignore-line */
        );

        $this->userRepository->upgradePassword($user, $hashedPassword);
    }

    public function canEditPassword(ForgetPassword $forgetPassword): bool
    {
        $date = new \DateTimeImmutable();

        return $date <= $forgetPassword->getLimitedAt();
    }

    public function remove(ForgetPassword $forgetPassword): void
    {
        $this->em->remove($forgetPassword);
        $this->em->flush();
    }
}
