<?php

namespace App\Twig;

use App\Repository\TagRepository;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(
        private TagRepository $tagRepository,
        private CacheManager $cache
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uploaded_asset', [$this, 'getUploadedAssetPath']),
            new TwigFunction('uploaded_banner', [$this, 'getUploadedBannerPath']),
            new TwigFunction('uploaded_banner_low', [$this, 'getUploadedBannerLowPath']),
            new TwigFunction('get_menu_tags', [$this, 'getMenuTags']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function getUploadedAssetPath(string $path): string
    {
        return 'uploads/banners/' . $path;
    }

    public function getUploadedBannerPath(string $path): string
    {
        return '/media/cache/blog_list/uploads/banners/' . $path;
    }

    public function getUploadedBannerLowPath(string $path): string
    {
        return 'app/public/media/cache/blog_list_low/uploads/banners/' . $path;
    }

    public function getMenuTags()
    {
        // find all tags that have is menu true
        return $this->tagRepository->findBy(['isMenu' => true], ['createdAt' => 'DESC']);
    }
}
