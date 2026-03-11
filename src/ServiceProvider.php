<?php

namespace Redcodede\Captcha;

use Statamic\Providers\AddonServiceProvider;
use Redcodede\Captcha\Tags\RefreshCaptcha;
use Redcodede\Captcha\Tags\CaptchaImage;

class ServiceProvider extends AddonServiceProvider
{
    public $captcha;

    protected $tags = [
        RefreshCaptcha::class,
        CaptchaImage::class,
    ];
    public function bootAddon()
    {
        $this->captcha = new Captcha();
    }
}
