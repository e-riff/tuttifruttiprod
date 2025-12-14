<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_INFOS = [
        [
            'email' => 'admin@mail.fr',
            'password' => 'motdepasse',
            'firstname' => 'Emeric',
            'lastname' => 'RIFF',
            'role' => 'ROLE_ADMIN',
        ],
    ];

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::ADMIN_INFOS as $adminInfo) {
            $user = new User();
            $user->setEmail($adminInfo['email']);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $adminInfo['password']
            );
            $user->setPassword($hashedPassword);

            $user->setRoles([$adminInfo['role']]);

            $user->setFirstname($adminInfo['firstname']);
            $user->setLastname($adminInfo['lastname']);
            //            $user->setIsVerified(true);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
