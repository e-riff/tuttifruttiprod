<?php

namespace App\DataFixtures;

use App\Entity\Concert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= BandFixtures::$bandIndex; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $concert = new concert();
                $concert->setCity($faker->city);
                $concert->setAddress($faker->streetAddress);
                $concert->setZipCode($faker->postcode);
                $concert->setClientName($faker->name);
                $concert->setIsConfirmed(true);
                $concert->setOtherInformations($faker->sentence(8));
                if ($j == 1) {
                    $concert->setDate($faker->dateTimeBetween("-2 month"));
                } else {
                    $concert->setDate($faker->dateTimeBetween("now", '+10 month'));
                }
                $concert->setBand($this->getReference("band_" . $i));

                $manager->persist($concert);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BandFixtures::class,
        ];
    }
}
