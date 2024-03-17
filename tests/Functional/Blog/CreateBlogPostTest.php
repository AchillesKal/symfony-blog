<?php

namespace Tests\Functional\Blog;

use App\Factory\UserFactory;
use Tests\AppPantherTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateBlogPostTest extends AppPantherTestCase
{
    use ResetDatabase;
    use Factories;

    public function testItWorks(): void
    {
        UserFactory::createOne();

        // test there are no articles
        $this->browser()
            ->visit('/')
            ->assertSee('No Articles found 😞')
        ;

        // login user
        $this->pantherBrowser()
            ->loginAs('test@mail.com', '1234')
            ->waitForPageLoad()
            ->assertOn('/')
            ->assertLoggedIn();
    }
}
