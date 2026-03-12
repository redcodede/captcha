<?php

namespace Redcodede\Captcha;

use Statamic\Providers\AddonServiceProvider;
use Redcodede\Captcha\Tags\RefreshCaptcha;
use Redcodede\Captcha\Tags\CaptchaImage;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        RefreshCaptcha::class,
        CaptchaImage::class,
        \Redcodede\Captcha\Tags\CaptchaRefreshUrl::class,
    ];

    public function register(): void
    {
        $this->app->singleton(Captcha::class, function ($app) {
            return new Captcha($app->make(Session::class));
        });
    }

    public function bootAddon(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Validator::extend(
            'captcha',
            fn ($attribute, $value, $parameters, $validator) => app(Captcha::class)->verify($value),
            'Bitte gib den Code aus dem Bild korrekt ein.'
        );
    }
}
