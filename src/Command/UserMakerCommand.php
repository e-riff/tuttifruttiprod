<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
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
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyIo = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');

        // Ask for the email
        $emailQuestion = new Question('Email: ');
        $email = $helper->ask($input, $output, $emailQuestion);

        // Ask for the first name
        $firstNameQuestion = new Question('First name: ');
        $firstName = $helper->ask($input, $output, $firstNameQuestion);

        // Ask for the last name
        $lastNameQuestion = new Question('Last name: ');
        $lastName = $helper->ask($input, $output, $lastNameQuestion);

        // Ask for the password
        $passwordQuestion = new Question('Password: ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $passwordQuestion);

        // Confirm the password
        $confirmPassQuestion = new Question('Confirm Password: ');
        $confirmPassQuestion->setHidden(true);
        $confirmPassQuestion->setHiddenFallback(false);
        $confirmPassword = $helper->ask($input, $output, $confirmPassQuestion);

        // Check if passwords match
        if ($password !== $confirmPassword) {
            $symfonyIo->error('Passwords do not match!');
            return Command::FAILURE;
        }

        // Create the user and set its properties
        $user = new User();
        $user->setEmail($email);
        $user->setFirstname($firstName);
        $user->setLastname($lastName);
        $user->setRoles(['ROLE_ADMIN']);

        // Hash the password and set it
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        // Persist and flush the user
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $symfonyIo->success('Admin user successfully created!');

        return Command::SUCCESS;
    }
}
