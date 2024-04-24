<?php

namespace App\Factory;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use App\Service\UploaderHelper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<BlogPost>
 *
 * @method        BlogPost|Proxy                     create(array|callable $attributes = [])
 * @method static BlogPost|Proxy                     createOne(array $attributes = [])
 * @method static BlogPost|Proxy                     find(object|array|mixed $criteria)
 * @method static BlogPost|Proxy                     findOrCreate(array $attributes)
 * @method static BlogPost|Proxy                     first(string $sortedField = 'id')
 * @method static BlogPost|Proxy                     last(string $sortedField = 'id')
 * @method static BlogPost|Proxy                     random(array $attributes = [])
 * @method static BlogPost|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BlogPostRepository|RepositoryProxy repository()
 * @method static BlogPost[]|Proxy[]                 all()
 * @method static BlogPost[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static BlogPost[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static BlogPost[]|Proxy[]                 findBy(array $attributes)
 * @method static BlogPost[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static BlogPost[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class BlogPostFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private UploaderHelper $uploaderHelper,
        #[Autowire(param: 'banner_directory')] private string $bannerDirectory,
    ) {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $file = new UploadedFile( __DIR__ . '/../../assets/images/test.webp', 'test.webp', test: true);

        $fileUpload = $this->uploaderHelper->uploadFile($file, $this->bannerDirectory, true);

        return [
            'title' => ucfirst(self::faker()->words(10, true)),
            'summary' => self::faker()->text,
            'content' => self::faker()->randomHtml(6, 10),
            'banner' => $fileUpload['filename'],
            'blurredThumbnail' => $fileUpload['blurredThumbnail'],
            'publishedAt' => self::faker()->dateTimeBetween('-3 month'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(BlogPost $blogPost): void {})
        ;
    }

    protected static function getClass(): string
    {
        return BlogPost::class;
    }
}
