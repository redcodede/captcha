<?php

namespace Redcodede\Captcha;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public $captcha;

    protected $tags = [
        \Redcodede\Captcha\Tags\RefreshCaptcha::class,
        \Redcodede\Captcha\Tags\CaptchaImage::class,
    ];
    public function bootAddon()
    {
        $this->captcha = new Captcha();
    }
}
