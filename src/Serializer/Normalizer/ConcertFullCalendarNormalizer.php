<?php

namespace App\Serializer\Normalizer;

use App\Entity\Concert;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConcertFullCalendarNormalizer implements NormalizerInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function normalize(mixed $data, ?string $format = null, array $context = []): array
    {
        /** @var Concert $concert */
        $concert = $data;

        $band = $concert->getBand();
        $city = $concert->getCity();
        $zipCode = $concert->getZipCode();

        $cityParts = [];
        if (null !== $city) {
            $cityParts[] = $city;
        }
        if (null !== $zipCode) {
            $cityParts[] = "({$zipCode})";
        }

        $completeCityName = implode(' ', $cityParts);
        $titleParts = array_filter([$band->getName(), $completeCityName]);
        $title = implode(' - ', $titleParts);

        $start = $concert->getDate()->format('Y-m-d\TH:i:s');
        $end = (clone $concert->getDate())->setTime(23, 59, 59)->format('Y-m-d\TH:i:s');

        return [
            'id' => (string) $concert->getId(),
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'backgroundColor' => $band->getColor(),
            'extendedProps' => [
                'url' => $this->urlGenerator->generate('band_show', ['slug' => $band->getSlug()]),
                'bandId' => (string) $band->getId(),
            ],
        ];
    }

    public function supportsNormalization(
        mixed $data,
        ?string $format = null,
        array $context = []
    ): bool {
        return $data instanceof Concert
            && $context['fullcalendar'] ?? false;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Concert::class => true,
            '*' => false,
        ];
    }
}
