<?php

namespace App\DataFixtures;

use App\Factory\BlogPostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne();
        BlogPostFactory::createMany(1000);
    }
}
