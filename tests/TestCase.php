<?php

namespace Redcodede\Captcha\Tests;

use Redcodede\Captcha\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
