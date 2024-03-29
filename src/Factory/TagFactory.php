<?php

namespace App\Factory;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Tag>
 *
 * @method        Tag|Proxy                     create(array|callable $attributes = [])
 * @method static Tag|Proxy                     createOne(array $attributes = [])
 * @method static Tag|Proxy                     find(object|array|mixed $criteria)
 * @method static Tag|Proxy                     findOrCreate(array $attributes)
 * @method static Tag|Proxy                     first(string $sortedField = 'id')
 * @method static Tag|Proxy                     last(string $sortedField = 'id')
 * @method static Tag|Proxy                     random(array $attributes = [])
 * @method static Tag|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TagRepository|RepositoryProxy repository()
 * @method static Tag[]|Proxy[]                 all()
 * @method static Tag[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Tag[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Tag[]|Proxy[]                 findBy(array $attributes)
 * @method static Tag[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Tag[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class TagFactory extends ModelFactory
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
            'title' => ucfirst(self::faker()->word()),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Tag $tag): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Tag::class;
    }
}
