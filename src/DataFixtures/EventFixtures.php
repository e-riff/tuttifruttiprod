<?php

namespace App\DataFixtures;

use App\Entity\MusicStyle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EventFixtures extends Fixture
{
    public function __construct(
        public readonly SluggerInterface $slugger,
        private readonly DecoderInterface $decoder,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'events.csv';
        $filePath = __DIR__ . '/data/' . $file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');
        //

        // $product = new Product();
        // $manager->persist($product);
    }
}
