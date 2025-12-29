<?php

declare(strict_types=1);

namespace App\Command;

use App\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'UserMakerCommand',
    description: 'Permet de créer un nouvel utilisateur',
)]
class UserMakerCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyIo = new SymfonyStyle($input, $output);

        $email = $symfonyIo->ask('Email: ');
        $firstName = $symfonyIo->ask('First name: ');
        $lastName = $symfonyIo->ask('Last name: ');
        $password = $symfonyIo->askHidden('Password: ');
        $confirmPassword = $symfonyIo->askHidden('Confirm Password: ');

        if ($password !== $confirmPassword) {
            $symfonyIo->error('Passwords do not match!');

            return Command::FAILURE;
        }

        $user = new User();
        $user->setEmail($email);
        $user->setFirstname($firstName);
        $user->setLastname($lastName);
        $user->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $symfonyIo->success('Admin user successfully created!');

        return Command::SUCCESS;
    }
}
