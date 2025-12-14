<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EventFixtures extends Fixture
{
    public static array $eventList = [];

    public function __construct(
        public readonly SluggerInterface $slugger,
        private readonly DecoderInterface $decoder,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'events.csv';
        $filePath = __DIR__.'/data/'.$file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $style) {
            $event = new Event();
            $event->setName($style['name']);

            $slug = (string) $this->slugger->slug(mb_strtolower($style['name']));
            $event->setSlug($slug);
            $this->addReference($slug, $event);
            self::$eventList[] = $slug;

            $manager->persist($event);
        }
        $manager->flush();
    }
}
