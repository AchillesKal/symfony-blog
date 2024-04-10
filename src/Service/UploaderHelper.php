<?php

namespace App\Service;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Liip\ImagineBundle\Service\FilterService;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class UploaderHelper
{
    private Filesystem $filesystem;

    public function __construct(
        private readonly SluggerInterface $slugger,
        private CacheManager $cacheManager,
        private FilterManager $filterManager,
        private DataManager $dataManager,
        private FilterService $filterService
    )
    {
        $this->filesystem = new Filesystem();
    }

    public function uploadFile(File $file, string $fileDirectory, $test = false): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // this is needed to safely include the file name as part of the URL
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();


        try {
            if (true === $test) {
                $this->filesystem->copy(
                    $file->getPathname(),
                    $fileDirectory.'/'.$newFilename
                );
            } else {
                $file->move(
                    $fileDirectory,
                    $newFilename
                );
            }

            if (!$this->filesystem->exists($filePath = $fileDirectory.'/'.$newFilename)) {
                throw new \InvalidArgumentException("Image does not exist.");
            }

            $search = '/app/public';
            $filePath = str_replace($search, '', $filePath);

            $this->filterService->getUrlOfFilteredImage($filePath, 'blog_list');
            $this->filterService->getUrlOfFilteredImage($filePath, 'blog_list_low');
        } catch (FileException $e) {
            dd($e->getMessage());
        }

        return $newFilename;
    }
}
