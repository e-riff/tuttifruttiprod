<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $bandIndex = 0;

    public function __construct(
        private readonly DecoderInterface $decoder,
        private readonly SluggerInterface $slugger,
        //private readonly ContainerBagInterface $containerBag
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'bands.csv';
        $filePath = __DIR__ . '/data/' . $file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $bandInfo) {
            self::$bandIndex++;
            $band = new Band();
            $band->setName($bandInfo['name']);
            $band->setIsActive($bandInfo['is_active']);
            $band->setSlug($this->slugger->slug($bandInfo['name']));
            $band->setTagline($bandInfo['tagline']);
            $band->setDescription($bandInfo["description"]);
            /*            $file = __DIR__ . '/data/band.jpg';
                        if (
                            copy($file, $this->containerBag->get("upload_directory") .
            "images/band/band". self::$bandIndex . ".jpg")
                        ) {
                            $band->setPicture("band". self::$bandIndex . ".jpg");
                        }*/

            foreach ($bandInfo as $key => $info) {
                if (in_array($key, MusicStyleFixtures::$styleList) && $info == true) {
                    $band->addMusicStyle($this->getReference($key));
                }
            }
            foreach ($bandInfo as $key => $info) {
                if (in_array($key, EventFixtures::$eventList) && $info == true) {
                    $band->addEvent($this->getReference($key));
                }
            }
            $manager->persist($band);
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            MusicStyleFixtures::class,
            EventFixtures::class,
        ];
    }
}
