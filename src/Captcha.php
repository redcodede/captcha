<?php

namespace Redcodede\Captcha;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Contracts\Session\Session;

class Captcha
{
    private const SESSION_KEY = 'redcodede.captcha.phrase';

    public function __construct(
        private readonly Session $session,
    ) {}

    public function image(): string
    {
        $phrase = $this->session->get(self::SESSION_KEY);

        if (! is_string($phrase) || $phrase === '') {
           return $this->refreshImage();
        }

        return $this->buildImage($phrase);
    }

    public function refreshImage(): string
    {
        $builder = $this->makeBuilder();

        $this->session->put(self::SESSION_KEY, $builder->getPhrase());

        return $builder->inline();
    }

    public function verify(?string $userInput, bool $forgetOnSuccess = true): bool
    {
        $storedPhrase = $this->session->get(self::SESSION_KEY);

        if (! is_string($storedPhrase) || $storedPhrase === '') {
            return false;
        }

        $normalizedInput = trim((string) $userInput);

        $isValid = hash_equals($storedPhrase, $normalizedInput);

        if ($isValid && $forgetOnSuccess) {
            $this->clear();
        }

        return $isValid;
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    private function buildImage(string $phrase): string
    {
        return $this->makeBuilder($phrase)->inline();
    }

    public static function makeBuilder(?string $phrase = null): CaptchaBuilder
    {
        $phraseBuilder = new PhraseBuilder(4, '0123456789');

        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->setDistortion(false);
        $builder->setScatterEffect(false);
        $builder->buildAgainstOCR($width = 150, $height = 40, $font = null);

        return $builder;
    }
}
