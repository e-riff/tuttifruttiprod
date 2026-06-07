<?php

declare(strict_types=1);

namespace App\Application\Media;

final readonly class ExtractYoutubeVideoId
{
    public function __invoke(string $rawLink): string
    {
        $query = parse_url($rawLink, PHP_URL_QUERY);
        if (!is_string($query)) {
            return $rawLink;
        }

        parse_str($query, $queryParameters);

        return is_string($queryParameters['v'] ?? null) ? $queryParameters['v'] : $rawLink;
    }
}
