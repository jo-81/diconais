<?php

namespace App\Service\Auth;

use App\Entity\ForgetPassword;
use App\Entity\User;
use App\Repository\ForgetPasswordRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ForgetPasswordService
{
    public function __construct(
        private UserRepository $userRepository,
        private ForgetPasswordRepository $forgetPasswordRepository,
        private EntityManagerInterface $em,
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGeneratorInterface
    ) {
    }

    public function getUserByEmail(string $email): User|null
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    public function exist(User $user): ForgetPassword|null
    {
        return $this->forgetPasswordRepository->findOneBy(['person' => $user]);
    }

    public function persist(User $user): ForgetPassword
    {
        $forgetPassword = new ForgetPassword();
        $forgetPassword->setPerson($user);
        $this->em->persist($forgetPassword);
        $this->em->flush();

        return $forgetPassword;
    }

    public function sendEmail(ForgetPassword $forgetPassword): void
    {
        /** @var User */
        $user = $forgetPassword->getPerson();

        $email = (new TemplatedEmail())
            ->from('diconais@domaine.fr')
            ->to(new Address($user->getEmail())) /* @phpstan-ignore-line */
            ->subject('Demande de renouvelllement de votre mot de passe')
            ->htmlTemplate('front/emails/forget_password.html.twig')
            ->context([
                'expiration_date' => $forgetPassword->getLimitedAt(),
                'created_at' => $forgetPassword->getCreatedAt(),
                'path' => $this->urlGeneratorInterface->generate('reset.password', ['token' => $forgetPassword->getToken()], UrlGeneratorInterface::ABSOLUTE_URL),
                'username' => $user->getUsername(),
            ])
        ;

        $this->mailer->send($email);
    }
}
