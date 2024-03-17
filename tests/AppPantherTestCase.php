<?php

namespace Tests;

use Symfony\Component\Panther\PantherTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class AppPantherTestCase extends PantherTestCase
{
    use HasBrowser {
        pantherBrowser as parentPantherBrowser;
    }

    protected function pantherBrowser(array $options = [], array $kernelOptions = [], array $managerOptions = []): AppBrowser
    {
        return $this->parentPantherBrowser($options, $kernelOptions, $managerOptions);
    }
}
