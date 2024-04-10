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

        foreach (['Travel', 'Deals', 'Entertainment', 'Science', 'Tech', 'Shopping'] as $title) {
            TagFactory::createOne(
                [
                    'title' => $title,
                    'isMenu' => true,
                ]
            );
        }

        TagFactory::createMany(15);
        BlogPostFactory::createMany(50, function() {
            return [
                'tags' => TagFactory::randomRange(1, 5),
            ];
        });
    }
}
