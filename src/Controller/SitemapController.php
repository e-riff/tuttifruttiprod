<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Band;
use App\Repository\BandRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[Route(name: 'sitemap_', defaults: ['_format' => 'xml'])]
class SitemapController extends AbstractController
{
    public function __construct(
        private readonly BandRepository $bandRepository,
        private readonly UploaderHelper $uploaderHelper,
        private readonly UrlHelper $urlHelper,
    ) {
    }

    #[Route('/sitemap.xml', name: 'sitemap_index', defaults: ['_format' => 'xml'])]
    public function index(): Response
    {
        $sitemaps = [
            [
                'loc' => $this->generateUrl('sitemap_main', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => (new DateTimeImmutable())->format('Y-m-d'),
            ],
            [
                'loc' => $this->generateUrl('sitemap_bands', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => (new DateTimeImmutable())->format('Y-m-d'),
            ],
        ];

        $response = $this->render('sitemap/index.xml.twig', [
            'sitemaps' => $sitemaps,
        ]);

        $response
            ->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    #[Route('/sitemap-main.xml', name: 'main')]
    public function sitemapMain(): Response
    {
        $urls = [
            [
                'loc' => $this->generateUrl('index', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => (new DateTimeImmutable())->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => $this->generateUrl('app_concert_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => (new DateTimeImmutable())->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
            [
                'loc' => $this->generateUrl('musician_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => (new DateTimeImmutable())->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
        ];

        $response = $this->render('sitemap/main.xml.twig', [
            'urls' => $urls,
        ]);
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    #[Route('/sitemap-groups.xml', name: 'bands')]
    public function sitemapGroups(): Response
    {
        $bands = $this->bandRepository->findBy(['isActive' => true]);

        $urls = array_map(fn (Band $band): array => $this->buildBandEntry($band), $bands);

        $response = $this->render('sitemap/bands.xml.twig', [
            'urls' => $urls,
        ]);

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    private function buildBandEntry(object $band): array
    {
        $entry = [
            'loc' => $this->generateUrl('band_show', ['slug' => $band->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL),
            'lastmod' => $band->getUpdatedAt()?->format('Y-m-d') ?? (new DateTimeImmutable())->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.9',
        ];

        if (null !== $band->getPicture()) {
            $entry['image'] = [
                'loc' => $this->urlHelper->getAbsoluteUrl($this->uploaderHelper->asset($band, 'pictureFile')),
                'title' => $band->getName(),
                'caption' => "Photo du groupe {$band->getName()}",
            ];
        }

        return $entry;
    }
}
