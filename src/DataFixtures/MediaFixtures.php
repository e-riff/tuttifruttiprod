<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Media;
use App\Enums\MediaTypeEnum;
use App\Repository\BandRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly DecoderInterface $decoder,
        private readonly BandRepository $bandRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'medias.csv';
        $filePath = __DIR__.'/data/'.$file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $mediaInfo) {
            $media = new Media();
            $media->setLink($mediaInfo['link']);
            $media->setMediaType(MediaTypeEnum::getType($mediaInfo['type']));
            $mediaBand = $this->bandRepository->findOneBy(['slug' => $mediaInfo['band']]);
            $media->setBand($mediaBand);
            $manager->persist($media);
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
