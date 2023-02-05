<?php

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
        $filePath = __DIR__ . '/data/' . $file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $eventData) {
            $event = new Event();
            $event->setName($eventData['name']);

            $event->setSlug($this->slugger->slug($eventData['name']));
            $this->addReference($event->getSlug(), $event);
            self::$eventList[] = $event->getSlug();

            $manager->persist($event);
        }

        $manager->flush();
    }
}
