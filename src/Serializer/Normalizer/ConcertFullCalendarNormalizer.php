<?php

namespace App\Serializer\Normalizer;

use App\Entity\Concert;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConcertFullCalendarNormalizer implements NormalizerInterface
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        $band = $object->getBand();
        $bandName = $object->getBand()->getName();
        $city = $object->getCity();
        $zipCode = $object->getZipCode();

        $parts = [];
        if ($city) {
            $parts[] = $city;
        }
        if ($zipCode) {
            $parts[] = "($zipCode)";
        }
        $completeCityName = implode(' ', $parts);
        $titleParts = array_filter([$bandName, $completeCityName]); // filtrer les vides
        $title = implode(' - ', $titleParts); // On concatène éventuellement " - $completeCityName" seulement si non vide

        $start = $object->getDate()->format('Y-m-d\TH:i:s');
        $end = (clone $object->getDate())->setTime(23, 59, 59)->format('Y-m-d\TH:i:s');
        return [
            'id' => (string)$object->getId(),
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'backgroundColor' => $band->getColor(),
            'extendedProps' => [
                'url' => $this->urlGenerator->generate('band_show', ['slug' => $band->getSlug()]),
                'bandId' => (string)$band->getId(),
            ],
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Concert && (isset($context['fullcalendar']) && $context['fullcalendar'] === true);
    }

    public function __call(string $name, array $arguments)
    {
        return [
            'object' => null,             // Doesn't support any classes or interfaces
            '*' => false,                 // Supports any other types, but the result is not cacheable
            ConcertFullCalendarNormalizer::class => true, //Supports ConcertFullCalendarNormalizer, and result cacheable
        ];
    }
}