<?php

namespace Redcodede\Captcha;

use Statamic\Providers\AddonServiceProvider;
use Redcodede\Captcha\Tags\RefreshCaptcha;
use Redcodede\Captcha\Tags\CaptchaImage;
use Illuminate\Contracts\Session\Session;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        RefreshCaptcha::class,
        CaptchaImage::class,
    ];

    public function register(): void
    {
        $this->app->singleton(Captcha::class, function ($app) {
            return new Captcha($app->make(Session::class));
        });
    }

    public function bootAddon(): void
    {
        //
    }
}
