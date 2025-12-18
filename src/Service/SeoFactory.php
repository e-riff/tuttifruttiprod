<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Band;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Contracts\Translation\TranslatorInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

final readonly class SeoFactory
{
    public const string DEFAULT_DOMAIN = 'seo';
    public const string ROUTE_BAND_SHOW = 'band_show';
    public const string TRANSL_KEY_TITLE = '.title';
    public const string TRANSL_KEY_DESC = '.description';
    public const string TITLE_SUFFIX = ' – Panel Production';

    public function __construct(
        private TranslatorInterface $translator,
        private UrlHelper $urlHelper,
        private UploaderHelper $uploaderHelper,
    ) {
    }

    public function createForRequest(
        Request $request,
        string $route,
        ?Band $band = null,
    ): array {
        if ($band instanceof Band) {
            return $this->createForBand($request, $band);
        }

        return $this->createForRoute($request, $route);
    }

    private function createForRoute(Request $request, string $route): array
    {
        $titleKey = $route . self::TRANSL_KEY_TITLE;
        $descKey = $route . self::TRANSL_KEY_DESC;

        $title = $this->translator->trans($titleKey, [], self::DEFAULT_DOMAIN);
        $description = $this->translator->trans($descKey, [], self::DEFAULT_DOMAIN);

        $seo = [
            'title' => $title !== $titleKey ? $title : null,
            'description' => $description !== $descKey ? $description : null,
        ];

        $seo['canonical'] = $this->urlHelper->getAbsoluteUrl($request->getRequestUri());

        return $seo;
    }

    private function createForBand(Request $request, Band $band): array
    {
        $name = $band->getName();
        $styles = array_map(fn ($s) => $s->getName(), $band->getMusicStyles()->toArray());
        $list = implode(', ', $styles);
        $url = $this->urlHelper->getAbsoluteUrl($request->getRequestUri());

        $imgPath = $this->uploaderHelper->asset($band, 'pictureFile');
        $imgUrl = $imgPath ? $this->urlHelper->getAbsoluteUrl($imgPath) : null;

        $title = $this->translator->trans(
            'band_show.title',
            ['name' => $name],
            self::DEFAULT_DOMAIN
        ) . self::TITLE_SUFFIX;

        $description = $this->translator->trans(
            'band_show.description',
            ['name' => $name, 'styles' => $list],
            self::DEFAULT_DOMAIN
        );

        return array_filter([
            'title' => $title,
            'description' => $description,
            'keywords' => implode(', ', array_merge([$name], $styles)),
            'og' => $this->buildOgTags($title, $description, $url, $imgUrl),
            'twitter' => $this->buildTwitterTags($title, $description, $imgUrl),
            'schema' => $this->buildSchema($name, $styles, $url, $imgUrl, $description),
            'canonical' => $url,
        ]);
    }

    private function buildOgTags(string $title, string $description, string $url, ?string $imgUrl): array
    {
        $og = [
            'og:title' => $title,
            'og:description' => $description,
            'og:url' => $url,
            'og:type' => 'music.group',
        ];
        if ($imgUrl) {
            $og['og:image'] = $imgUrl;
        }

        return $og;
    }

    private function buildTwitterTags(string $title, string $description, ?string $imgUrl): array
    {
        $twitter = [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $title,
            'twitter:description' => $description,
        ];
        if ($imgUrl) {
            $twitter['twitter:image'] = $imgUrl;
        }

        return $twitter;
    }

    private function buildSchema(
        string $name,
        array $genres,
        string $url,
        ?string $imgUrl,
        string $description,
    ): array {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'MusicGroup',
            'name' => $name,
            'genre' => $genres,
            'url' => $url,
            'description' => strip_tags($description),
        ];
        if ($imgUrl) {
            $schema['image'] = $imgUrl;
        }

        return $schema;
    }
}
