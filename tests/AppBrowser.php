<?php

namespace Tests;

use Tests\Browser\AuthenticationExtension;
use Zenstruck\Browser\PantherBrowser;

class AppBrowser extends PantherBrowser
{
    use AuthenticationExtension;

    public function waitForPageLoad(): self
    {
        $this->client()->waitFor('html[aria-busy="true"]');

        return $this;
    }
}
