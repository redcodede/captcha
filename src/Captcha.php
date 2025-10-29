<?php

namespace Redcodede\Captcha;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Redcodede\Captcha\Tags\RefreshCaptcha;

class Captcha
{

    private static $builder;
    private static $phraseBuilder;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE || session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['captcha']) && $_SESSION['captcha'] != null) return;

        self::newBuild();
        self::refreshCaptcha();
    }

    public static function newBuild()
    {
        self::$phraseBuilder = new PhraseBuilder(4, '0123456789');
        Captcha::$builder = new CaptchaBuilder(null, self::$phraseBuilder);
        Captcha::$builder->setDistortion(false);
        Captcha::$builder->setScatterEffect(false);
        Captcha::$builder->buildAgainstOCR($width = 150, $height = 40, $font = null);
    }

    public static function storeCaptchaImage()
    {
        return $_SESSION['captcha'] = self::$builder->inline();
    }

    public static function outputCaptchaImage()
    {
        return self::$builder->inline();
    }

    public static function storeCaptchaPhrase()
    {
        return $_SESSION['phrase'] = self::$builder->getPhrase();
    }

    public static function outputCaptchaPhrase()
    {
        return self::$builder->getPhrase();
    }

    public static function refreshCaptcha()
    {
        if (Captcha::$builder == null) self::newBuild();
        $_SESSION['phrase'] = null;
        $_SESSION['captcha'] = null;
        self::storeCaptchaImage();
        self::storeCaptchaPhrase();
    }

    public function verifyCaptcha($userInput)
    {
        try {
            return self::$builder->testPhrase($userInput);
        } catch (Exception $e) {
            return false;
        }
    }
}
