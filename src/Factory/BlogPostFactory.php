<?php

namespace App\Factory;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->words(5, true),
            'content' => self::faker()->paragraphs(5, true)
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
