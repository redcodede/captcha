<?php

namespace Redcodede\Captcha;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Log;

class Captcha
{
    private const SESSION_KEY = 'redcodede.captcha.phrase';

    public function __construct(
        private readonly Session $session,
    ) {
    }

    public function image(): string
    {
        $phrase = $this->session->get(self::SESSION_KEY);

        Log::debug('captcha.image', [
            'session_id' => $this->session->getId(),
            'stored_phrase' => $phrase,
            'url' => request()->fullUrl(),
        ]);

        if (! is_string($phrase) || $phrase === '') {
            return $this->refreshImage();
        }

        return $this->buildImage($phrase);
    }

    public function refreshImage(): string
    {
        $builder = $this->makeBuilder();
        $phrase = $builder->getPhrase();

        $this->session->put(self::SESSION_KEY, $phrase);

        Log::debug('captcha.refresh', [
            'session_id' => $this->session->getId(),
            'new_phrase' => $phrase,
            'url' => request()->fullUrl(),
        ]);

        return $builder->inline();
    }

    public function verify(?string $userInput, bool $forgetOnSuccess = true): bool
    {
        $storedPhrase = $this->session->get(self::SESSION_KEY);
        $normalizedInput = trim((string) $userInput);

        Log::debug('captcha.verify', [
            'session_id' => $this->session->getId(),
            'stored_phrase' => $storedPhrase,
            'user_input' => $normalizedInput,
            'url' => request()->fullUrl(),
        ]);

        if (! is_string($storedPhrase) || $storedPhrase === '') {
            return false;
        }

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

    private function makeBuilder(?string $phrase = null): CaptchaBuilder
    {
        $phraseBuilder = new PhraseBuilder(4, '0123456789');

        $builder = new CaptchaBuilder($phrase, $phraseBuilder);
        $builder->setDistortion(false);
        $builder->setScatterEffect(false);
        $builder->buildAgainstOCR(150, 40);

        return $builder;
    }
}