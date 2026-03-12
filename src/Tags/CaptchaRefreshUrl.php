<?php

namespace Redcodede\Captcha\Tags;

use Statamic\Tags\Tags;

class CaptchaRefreshUrl extends Tags
{
    protected static $handle = 'captcha_refresh_url';

    public function index(): string
    {
        return route('redcodede.captcha.refresh');
    }
}