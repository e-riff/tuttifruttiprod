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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    private const string DATA_BANDS_DIR = __DIR__ . '/data/bands/';
    private const string FALLBACK_PICTURE = 'band.webp';
    private const string EXT = '.webp';
    public static int $bandIndex = 0;

    public function __construct(
        private readonly DecoderInterface $decoder,
        private readonly SluggerInterface $slugger,
        private readonly Filesystem $filesystem,
        #[Autowire('%upload_directory%images/band/')]
        private readonly string $bandPicturesDir,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'bands.csv';
        $filePath = __DIR__ . '/data/' . $file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');
        $this->filesystem->mkdir($this->bandPicturesDir);

        foreach ($csv as $bandInfo) {
            $slug = $this->slugger->slug($bandInfo['name'])->lower();
            ++self::$bandIndex;
            $band = new Band();
            $band->setName($bandInfo['name']);
            $band->setIsActive(filter_var($bandInfo['is_active'], FILTER_VALIDATE_BOOLEAN));
            $band->setSlug((string) $slug);
            $band->setTagline($bandInfo['tagline']);
            $band->setDescription($bandInfo['description']);
            $band->setPriceCategory(BandPriceEnum::getType($bandInfo['price_category']));

            $sourceCandidate = self::DATA_BANDS_DIR . $slug . self::EXT;
            $targetPath = $this->bandPicturesDir . $slug . self::EXT;

            $origin = is_file($sourceCandidate)
                ? $sourceCandidate
                : self::DATA_BANDS_DIR . self::FALLBACK_PICTURE;

            $this->filesystem->copy($origin, $targetPath, true);
            $band->setPicture($slug . self::EXT);

            foreach ($bandInfo as $key => $info) {
                if (in_array($key, MusicStyleFixtures::$styleList) && filter_var($info, FILTER_VALIDATE_BOOLEAN)) {
                    $band->addMusicStyle($this->getReference($key, MusicStyle::class));
                }
            }
            foreach ($bandInfo as $key => $info) {
                if (in_array($key, EventFixtures::$eventList) && filter_var($info, FILTER_VALIDATE_BOOLEAN)) {
                    $band->addEvent($this->getReference($key, Event::class));
                }
            }
            $this->addReference('band_' . self::$bandIndex, $band);

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
