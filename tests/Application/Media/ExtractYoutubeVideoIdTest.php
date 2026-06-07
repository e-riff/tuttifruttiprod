<?php

declare(strict_types=1);

namespace App\Tests\Application\Media;

use App\Application\Media\ExtractYoutubeVideoId;
use PHPUnit\Framework\TestCase;

final class ExtractYoutubeVideoIdTest extends TestCase
{
    public function testItExtractsVideoIdFromYoutubeUrl(): void
    {
        $extractYoutubeVideoId = new ExtractYoutubeVideoId();

        self::assertSame(
            'abc123',
            $extractYoutubeVideoId('https://www.youtube.com/watch?v=abc123&feature=shared')
        );
    }

    public function testItKeepsRawValueWhenNoVideoParameterExists(): void
    {
        $extractYoutubeVideoId = new ExtractYoutubeVideoId();

        self::assertSame('abc123', $extractYoutubeVideoId('abc123'));
    }
}
