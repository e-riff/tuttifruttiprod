<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Band;
use App\Entity\Event;
use App\Entity\MusicStyle;
use App\Enums\BandPriceEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $bandIndex = 0;

    public function __construct(
        private readonly DecoderInterface $decoder,
        private readonly SluggerInterface $slugger,
        #[Autowire('%upload_directory%')]
        private readonly string $uploadDirectory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'bands.csv';
        $filePath = __DIR__.'/data/'.$file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $bandInfo) {
            $slug = $this->slugger->slug($bandInfo['name'])->lower();
            ++self::$bandIndex;
            $band = new Band();
            $band->setName($bandInfo['name']);
            $band->setIsActive($bandInfo['is_active']);
            $band->setSlug((string) $slug);
            $band->setTagline($bandInfo['tagline']);
            $band->setDescription($bandInfo['description']);
            $band->setPriceCategory(BandPriceEnum::getType($bandInfo['price_category']));

            $file = __DIR__.'/data/bands/'.$slug.'.webp';

            if (file_exists($file)) {
                if (
                    copy($file, $this->uploadDirectory.
                        'images/band/'.$slug.'.webp')
                ) {
                    $band->setPicture($slug.'.webp');
                }
            } else {
                if (
                    copy(__DIR__.'/data/bands/band.webp', $this->uploadDirectory.
                        'images/band/'.$slug.'.webp')
                ) {
                    $band->setPicture($slug.'.webp');
                }
            }

            foreach ($bandInfo as $key => $info) {
                if (in_array($key, MusicStyleFixtures::$styleList) && true == $info) {
                    $band->addMusicStyle($this->getReference($key, MusicStyle::class));
                }
            }
            foreach ($bandInfo as $key => $info) {
                if (in_array($key, EventFixtures::$eventList) && true == $info) {
                    $band->addEvent($this->getReference($key, Event::class));
                }
            }
            $this->addReference('band_'.self::$bandIndex, $band);

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
