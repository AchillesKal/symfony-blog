<?php

namespace App\DataFixtures;

use App\Factory\BlogPostFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne();
        TagFactory::createMany(20);
        BlogPostFactory::createMany(100, function() {
            return [
                'tags' => TagFactory::randomRange(1, 5),
            ];
        });
    }
}
