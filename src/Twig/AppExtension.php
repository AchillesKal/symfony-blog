<?php

namespace App\Twig;

use App\Repository\TagRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private TagRepository $tagRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uploaded_asset', [$this, 'getUploadedAssetPath']),
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

    public function getMenuTags()
    {
        // find all tags that have is menu true
        return $this->tagRepository->findBy(['isMenu' => true], ['createdAt' => 'DESC']);
    }
}
