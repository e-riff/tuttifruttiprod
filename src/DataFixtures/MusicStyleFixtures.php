<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\MusicStyle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class MusicStyleFixtures extends Fixture
{
    public static array $styleList = [];

    public function __construct(
        private readonly DecoderInterface $decoder,
        private readonly SluggerInterface $slugger,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'musicStyle.csv';
        $filePath = __DIR__.'/data/'.$file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $style) {
            $musicStyle = new MusicStyle();
            $musicStyle->setName($style['name']);

            $musicStyle->setSlug((string) $this->slugger->slug($style['name']));
            $this->addReference($musicStyle->getSlug(), $musicStyle);
            self::$styleList[] = $musicStyle->getSlug();

            $manager->persist($musicStyle);
        }
        $manager->flush();
    }
}
