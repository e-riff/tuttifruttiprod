<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Repository\MusicStyleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly DecoderInterface $decoder,
        private readonly SluggerInterface $slugger,
    )
    {
    }
    public function load(ObjectManager $manager): void
    {
        $file = 'bands.csv';
        $filePath = __DIR__ . '/data/' . $file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $bandInfo) {
            $band = new Band();
            $band->setName($bandInfo['name']);
            $band->setIsActive($bandInfo['is_active']);
            $band->setSlug($this->slugger->slug($bandInfo['name']));
            $band->setDescription($bandInfo["description"]);

            foreach($bandInfo as $key=>$info) {
                if (in_array($key, MusicStyleFixtures::$styleList) && $info==true) {
                    $band->addMusicStyle($this->getReference($key));
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
        ];
    }
}
